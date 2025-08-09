<?php

namespace Flux\Compiler;

use Flux\Support\StrUtil;
use Illuminate\Support\Str;
use Illuminate\View\AnonymousComponent;

class FluxComponentDirectives
{
    public static function compileFluxComponentClass($expression)
    {
        [$component, $alias, $data] = str_contains($expression, ',')
            ? array_map('trim', explode(',', trim($expression, '()'), 3)) + ['', '', '']
            : [trim($expression, '()'), '', ''];

        $component = trim($component, '\'"');

        $hash = ComponentHashes::newComponentHash(
            $component === AnonymousComponent::class ? $component.':'.trim($alias, '\'"') : $component
        );

        if (Str::contains($component, ['::class', '\\'])) {
            return static::compileClassComponentOpening($component, $alias, $data, $hash);
        }

        return "<?php \$__env->startComponent{$expression}; ?>";
    }

    public static function compileClassComponentOpening(string $component, string $alias, string $data, string $hash)
    {
        $componentData = $data ?: '[]';

        return implode("\n", [
            '<?php if (isset($component)) { $__componentOriginal'.$hash.' = $component; } ?>',
            '<?php if (isset($attributes)) { $__attributesOriginal'.$hash.' = $attributes; } ?>',
            '<?php $component = '.$component.'::resolve('.$data.' ?? [] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>',
            '<?php $component->withName('.$alias.'); ?>',
            '<?php if ($component->shouldRender()): ?>', /* START: RENDER */
            '<?php $__env->startComponent($component->resolveView(), $component->data()); ?>',
        ]);
    }

    public static function compileEndFluxComponentClass()
    {
        $hash = ComponentHashes::popHash();

        return <<<PHP
<?php
    if (isset(\$__fluxCacheKey{$hash})) { \$__fluxCacheKeyOriginal{$hash} = \$__fluxCacheKey{$hash}; }
    \$__componentRenderData{$hash} = \$__env->fluxComponentData();
    \$__fluxCacheKey{$hash} = \Flux\Flux::cache()->key(\$component->componentName, \$__componentRenderData{$hash}, \$__env);
    if (\$__fluxCacheKey{$hash} === null || \Flux\Flux::cache()->has(\$__fluxCacheKey{$hash}) === false): /* START: CACHE BLOCK */

    \Flux\Flux::cache()->startObserving(\$component->componentName);
    \$__fluxTmpOutput{$hash} = \$__env->renderFluxComponent(\$__componentRenderData{$hash});
    \Flux\Flux::cache()->stopObserving(\$component->componentName);
    \$__fluxCacheKey{$hash} = \Flux\Flux::cache()->key(\$component->componentName, \$__componentRenderData{$hash}, \$__env);
    
    if (\$__fluxCacheKey{$hash} !== null) {
        \Flux\Flux::cache()->put(\$component->componentName, \$__fluxCacheKey{$hash}, \$__fluxTmpOutput{$hash});
        \$__fluxTmpOutput{$hash} = \Flux\Flux::cache()->swap(
            \$component->componentName,
            \$__fluxTmpOutput{$hash},
            \Flux\Flux::cache()->runComponentSetup(\$component->componentName, \$__componentRenderData{$hash})
        );
    }

    echo \$__fluxTmpOutput{$hash};
    unset(\$__fluxTmpOutput{$hash});
    
    else: /* ELSE: CACHE BLOCK */
        \$__env->popFluxComponent();
        \$__fluxTmpOutput{$hash} = \Flux\Flux::cache()->swap(
            \$component->componentName,
            \Flux\Flux::cache()->get(\$__fluxCacheKey{$hash}),
            \Flux\Flux::cache()->runComponentSetup(\$component->componentName, \$__componentRenderData{$hash})
        );
        echo \$__fluxTmpOutput{$hash};
        
        unset(\$__fluxTmpOutput{$hash});
    endif; /* END: CACHE BLOCK */
    
    endif; /* END: RENDER */

    
    if (isset(\$__fluxCacheKey{$hash})) { unset(\$__fluxCacheKey{$hash}); }
    if (isset(\$__fluxCacheKeyOriginal{$hash})) {
        \$__fluxCacheKey{$hash} = \$__fluxCacheKeyOriginal{$hash};
        unset(\$__fluxCacheKeyOriginal{$hash});
    }
    if (isset(\$__componentRenderData{$hash})) { unset(\$__componentRenderData{$hash}); }
    if (isset(\$__attributesOriginal{$hash})) {
        \$attributes = \$__attributesOriginal{$hash}; unset(\$__attributesOriginal{$hash});
    }
    
    if (isset(\$__componentOriginal{$hash})) {
        \$component = \$__componentOriginal{$hash}; unset(\$__componentOriginal{$hash});
    }
?>
PHP;
    }

    public static function compileCached($expression)
    {
        $expression = trim($expression);

        while (Str::startsWith($expression, '(') && Str::endsWith($expression, ')')) {
            $expression = trim(Str::substr($expression, 1, -1));
        }

        if (! $expression) {
            return '<?php Flux::shouldCache(); ?>';
        }

        return <<<PHP
<?php
    Flux::shouldCache();
    \$__fluxCacheOptions = $expression;
    
    if (isset(\$__fluxCacheOptions['except'])) {
        \$attributes = Flux::cache()->ignoreAttributes(\$__fluxCacheOptions['except'], get_defined_vars());
    }
    
    unset(\$__fluxCacheOptions);
?>
PHP;
    }

    public static function compileFluxAware($expression)
    {
        return "<?php foreach ({$expression} as \$__key => \$__value) {
    \$__consumeVariable = is_string(\$__key) ? \$__key : \$__value;
    if (is_string (\$__key)) {
        \$\$__consumeVariable = \$__env->getConsumableComponentData(\$__key, \$__value);
        \Flux\Flux::cache()->usesVariable(\$___key, \$\$__consumeVariable, \$__value);
    } else {
        \$\$__consumeVariable = \$__env->getConsumableComponentData(\$__value);
        \Flux\Flux::cache()->usesVariable(\$__value, \$\$__consumeVariable);
    }
} ?>";
    }
}