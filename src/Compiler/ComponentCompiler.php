<?php

namespace Flux\Compiler;

use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;

class ComponentCompiler extends ComponentTagCompiler
{
    protected $isOptimizedComponent = false;

    public function isFluxComponent($value)
    {
        return Str::startsWith(ltrim($value), ['@cached', '@optimized']);
    }

    protected function compileOptimizedComponent($value)
    {
        $this->isOptimizedComponent = true;

        $value = ltrim(preg_replace('/(?<!@)@optimized/', '', $value));

        return "<?php Flux::shouldOptimize(); ?>\n@uncached\n$value\n@enduncached";
    }

    protected function removeCacheFeatures($value)
    {
        $value = preg_replace('/(?<!@)@optimized/', '', $value);
        $value = preg_replace('/(?<!@)@cached/', '', $value);

        $value = $this->compileUncachedComponent($value);
        $value = $this->compileUncachedDirective($value);

        return $value;
    }

    public function compile($value)
    {
        if (! $value) {
            return $value;
        }

        if (! $this->isFluxComponent($value)) {
            return $value;
        }

        if (! Flux::cacheEnabled()) {
            return $this->removeCacheFeatures($value);
        }

        if (Str::startsWith(ltrim($value), '@optimized')) {
            $value = $this->compileOptimizedComponent($value);
        }

        $value = preg_replace('/(?<!@)@cached/', '<?php Flux::shouldCache(); ?>', $value);

        if (! $this->isOptimizedComponent) {
            $value = preg_replace('/(?<!@)@props\(/', '@fluxProps(', $value);
            $value = preg_replace('/(?<!@)@aware\(/', '@fluxAware(', $value);
        }

        $value = $this->compileUncachedComponent($value);
        $value = $this->compileUncachedDirective($value);

        return $value;
    }

    protected function compileUncached($content, $excludeExpression)
    {
        if (! Flux::cacheEnabled()) {
            return $content;
        }

        $replacement = '__FLUX::SWAP_REPLACEMENT::'. Str::random();

        $compiledExclude = '';

        if (strlen($excludeExpression) > 0) {
            $compiledExclude = "\Flux\Flux::cache()->exclude({$excludeExpression});";
        }

        return <<<PHP
<?php
    $compiledExclude
    \Flux\Flux::cache()->addSwap('$replacement', function (\$data) {
        extract(\$data);
        \$__env = \$__env ?? view();
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

                if (isset($attributes['exclude'])) {
                    $variables = str(mb_substr($attributes['exclude'], 1, -1))
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