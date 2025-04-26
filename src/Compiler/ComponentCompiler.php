<?php

namespace Flux\Compiler;

use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;

class ComponentCompiler extends ComponentTagCompiler
{
    public function isFluxComponent($value)
    {
        return Str::startsWith(ltrim($value), '@cached');
    }

    public function compile($value)
    {
        if (! $value) {
            return $value;
        }

        if (! $this->isFluxComponent($value)) {
            return $value;
        }

        $value = preg_replace('/(?<!@)@cached/', '<?php Flux::shouldCache(); ?>', $value);
        $value = preg_replace('/(?<!@)@props\(/', '@fluxProps(', $value);
        $value = preg_replace('/(?<!@)@aware\(/', '@fluxAware(', $value);

        $value = $this->compileUncachedComponent($value);
        $value = $this->compileUncachedDirective($value);

        return $value;
    }

    protected function compileUncached($content, $excludeExpression)
    {
        $replacement = '__FLUX::SWAP_REPLACEMENT::'. Str::random();

        $compiledExclude = '';

        if (strlen($excludeExpression) > 0) {
            $compiledExclude = "\Flux\Flux::cache()->exclude({$excludeExpression});";
        }

        $component = Flux::cache()->currentComponent();

        return <<<PHP
<?php
    $compiledExclude
    \Flux\Flux::cache()->addSwap('$replacement', function (\$data) {
        extract(\$data);
        \$attributes ??= new \\Illuminate\\View\\ComponentAttributeBag;

        \$__newAttributes = [];
        [\$__propNames, \$__originalPropValues] = \Flux\Flux::cache()->componentProps('$component');
        
        foreach (\$attributes->all() as \$__key => \$__value) {
            if (in_array(\$__key, \$__propNames)) {
                \$\$__key = \$\$__key ?? \$__value;
            } else {
                \$__newAttributes[\$__key] = \$__value;
            }
        }
        
        \$attributes = new \Illuminate\View\ComponentAttributeBag(\$__newAttributes);
        unset(\$__propNames);
        unset(\$__newAttributes);
        
        foreach (array_filter(\$__originalPropValues, 'is_string', ARRAY_FILTER_USE_KEY) as \$__key => \$__value) {
            \$\$__key = \$\$__key ?? \$__value;
        }
        unset(\$__originalPropValues);       
        
        \$__defined_vars = get_defined_vars();
        
        foreach (\$attributes->all() as \$__key => \$__value) {
            if (array_key_exists(\$__key, \$__defined_vars)) unset(\$\$__key);
        }
        
        unset(\$__defined_vars);
        ob_start();
?>$content<?php
        return ob_get_clean();
    });
?>$replacement
PHP;
    }

    protected function compileUncachedComponent($value)
    {
        return preg_replace_callback('/<flux:uncached(?:\s+([^>]+))?>(.*?)<\/flux:uncached>/s', function ($matches) {
            $excludeExpression = '';

            if ($matches[1]) {
                $attributes = $this->getAttributesFromAttributeString($matches[1]);

                if (isset($attributes['use'])) {
                    $variables = str(mb_substr($attributes['use'], 1, -1))
                        ->explode(',')
                        ->map(fn ($var) => "'{$var}'")
                        ->implode(', ');
                    $excludeExpression = '['.$variables.']';
                }
            }

            return $this->compileUncached($matches[2], $excludeExpression);
        }, $value);
    }

    protected function compileUncachedDirective($value)
    {
        return preg_replace_callback('/@uncached(?:\((.*?)\))?([\s\S]*?)@enduncached/s', function ($matches) {
            return $this->compileUncached(trim($matches[2]), $matches[1] ?? '');
        }, $value);
    }
}