<?php

namespace Flux\Compiler;

use Illuminate\Support\Str;
use Illuminate\View\AnonymousComponent;

class FluxComponentDirectives
{
    protected static function normalizeLineEndings($value)
    {
        return str_replace(["\r\n", "\r"], "\n", $value);
    }

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
            '<?php if (isset($__fluxHoistedComponentData)) { $__fluxHoistedComponentDataOriginal'.$hash.' = $__fluxHoistedComponentData; } ?>',
            '<?php $__fluxHoistedComponentData = '.$componentData.'; ?>',
            '<?php $component = '.$component.'::resolve($__fluxHoistedComponentData + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>',
            '<?php $component->withName('.$alias.'); ?>',
            '<?php if ($component->shouldRender()): ?>', /* START: RENDER */
            '<?php $__env->startComponent($component->resolveView(), $component->data()); ?>',
        ]);
    }

    public static function compileEndFluxComponentClass()
    {
        $hash = ComponentHashes::popHash();

        return static::normalizeLineEndings(<<<PHP
<?php
    if (isset(\$__fluxHoistedComponentData)) { \$__fluxHoistedComponentDataOriginal{$hash} = \$__fluxHoistedComponentData; } /* Preserve data in the event someone is nesting the same component over, and over, and over. */
    \$__fluxCacheKey{$hash} = \Flux\Flux::runtimeCache()->key(\$component->componentName, \$__fluxHoistedComponentData['data'], \$__env);
    \$__componentRenderData{$hash} = \$__env->fluxComponentData();
    if (isset(\$__fluxCacheKey{$hash})) { \$__fluxCacheKeyOriginal{$hash} = \$__fluxCacheKey{$hash}; }
    if (\$__fluxCacheKey{$hash} === null || \Flux\Flux::runtimeCache()->has(\$__fluxCacheKey{$hash}) === false): /* START: CACHE BLOCK */

    \Flux\Flux::runtimeCache()->startObserving(\$component->componentName);
    \$__fluxTmpOutput{$hash} = \$__env->renderFluxComponent(\$__componentRenderData{$hash});
    \Flux\Flux::runtimeCache()->stopObserving(\$component->componentName);
    \$__fluxCacheKey{$hash} = \Flux\Flux::runtimeCache()->key(\$component->componentName, \$__fluxHoistedComponentData['data'], \$__env);
    
    if (\$__fluxCacheKey{$hash} !== null) {
        \Flux\Flux::runtimeCache()->put(\$component->componentName, \$__fluxCacheKey{$hash}, \$__fluxTmpOutput{$hash});
        \$__fluxTmpOutput{$hash} = \Flux\Flux::runtimeCache()->swap(\$component->componentName, \$__fluxTmpOutput{$hash}, \$__componentRenderData{$hash});
    }

    echo \$__fluxTmpOutput{$hash};
    unset(\$__fluxTmpOutput{$hash});
    
    else: /* ELSE: CACHE BLOCK */
        \$__env->popFluxComponent();
        \$__fluxTmpOutput{$hash} = \Flux\Flux::runtimeCache()->get(\$__fluxCacheKey{$hash});
        \$__fluxTmpOutput{$hash} = \Flux\Flux::runtimeCache()->swap(\$component->componentName, \$__fluxTmpOutput{$hash}, \$__componentRenderData{$hash});
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
    if (isset(\$__fluxHoistedComponentData)) { unset(\$__fluxHoistedComponentData); }
    if (isset(\$__attributesOriginal{$hash})) {
        \$attributes = \$__attributesOriginal{$hash}; unset(\$__attributesOriginal{$hash});
    }
    
    if (isset(\$__componentOriginal{$hash})) {
        \$component = \$__componentOriginal{$hash}; unset(\$__componentOriginal{$hash});
    }
    
    if (isset(\$__fluxHoistedComponentDataOriginal{$hash})) {
        \$__fluxHoistedComponentData = \$__fluxHoistedComponentDataOriginal{$hash}; unset(\$__fluxHoistedComponentDataOriginal{$hash});
    }
?>
PHP);
    }

    public static function compileFluxAware($expression)
    {
        return static::normalizeLineEndings("<?php foreach ({$expression} as \$__key => \$__value) {
    \$__consumeVariable = is_string(\$__key) ? \$__key : \$__value;
    if (is_string (\$__key)) {
        \$\$__consumeVariable = \$__env->getConsumableComponentData(\$__key, \$__value);
        \Flux\Flux::runtimeCache()->usesVariable(\$___key, \$\$__consumeVariable, \$__value);
    } else {
        \$\$__consumeVariable = \$__env->getConsumableComponentData(\$__value);
        \Flux\Flux::runtimeCache()->usesVariable(\$__value, \$\$__consumeVariable);
    }
} ?>");
    }
}