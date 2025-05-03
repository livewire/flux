<?php

namespace Flux\Compiler;

use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\ComponentTagCompiler;

class ComponentCompiler extends ComponentTagCompiler
{
    protected $isOptimizedComponent = false;

    public $outputOptimizations = false;

    protected $uncachedBuffer = [];

    public function isFluxComponent($value)
    {
        return Str::startsWith(ltrim($value), ['@cached', '@optimized']);
    }

    protected function compileOptimizedComponent($value)
    {
        $this->isOptimizedComponent = true;

        return OptimizedComponentCompiler::compile($value);
    }

    protected function compileComponent($value)
    {
        $value = $this->compileSetupComponent($value);
        $value = $this->compileSetupDirective($value);
        $value = $this->compileUncachedComponent($value);
        $value = $this->compileUncachedDirective($value);

        $value .= implode("\n", $this->uncachedBuffer);

        $this->uncachedBuffer = [];

        return $value;
    }

    protected function removeCacheFeatures($value)
    {
        $value = preg_replace('/(?<!@)@optimized/', '', $value);
        $value = preg_replace('/(?<!@)@cached/', '', $value);

        return $this->compileComponent($value);
    }

    public function compile($value)
    {
        if (! $value) {
            return $value;
        }

        if (! $this->isFluxComponent($value)) {
            return $value;
        }

        if (! $this->outputOptimizations) {
            return $this->removeCacheFeatures($value);
        }

        $value = ltrim($value);

        if (Str::startsWith($value, '@optimized')) {
            $value = $this->compileOptimizedComponent($value);
        }

        if (! $this->isOptimizedComponent) {
            $value = preg_replace('/(?<!@)@aware\(/', '@fluxAware(', $value);
        }

        return $this->compileComponent($value);
    }

    protected function compileSetup($content)
    {
        if (! $this->outputOptimizations) {
            return $content;
        }

        return <<<PHP
<?php
    \Flux\Flux::cache()->registerSetup(function (\$__tmpComponentData) {
        extract(\$__tmpComponentData);
        \$__env = \$__env ?? view();
        ?>{$content}<?php
        unset(\$__tmpComponentData);
        return get_defined_vars();
    });
    extract(\Flux\Flux::cache()->runCurrentComponentSetup(get_defined_vars()));
?>
PHP;
    }

    protected function compileUncached($content, $excludeExpression)
    {
        if (! $this->outputOptimizations) {
            return $content;
        }

        $replacement = '__FLUX::SWAP_REPLACEMENT::'. Str::random();

        $compiledExclude = '';

        if (strlen($excludeExpression) > 0) {
            $compiledExclude = "\Flux\Flux::cache()->exclude({$excludeExpression});";
        }

        $this->uncachedBuffer[] = <<<PHP
<?php
    $compiledExclude
    \Flux\Flux::cache()->addSwap('$replacement', function (\$data) {
        extract(\$data);
        \$__env = \$__env ?? view();
        ob_start();
?>[FLUX_SWAP:COMPILED $replacement]<?php
        return ob_get_clean();
    });
?>
PHP;

        return <<<PHP
[FLUX_SWAP:BEGIN $replacement]
$content
[FLUX_SWAP:END]
PHP;
    }

    protected function compileSetupComponent($value)
    {
        return preg_replace_callback('/<flux:setup(?:\s+([^>]+))?>(.*?)<\/flux:setup>/s', function ($matches) {
            return $this->compileSetup(trim($matches[2]));
        }, $value);
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

            return $this->compileUncached(trim($matches[2]), $excludeExpression);
        }, $value);
    }

    protected function compileSetupDirective($value)
    {
        return preg_replace_callback('/@setup(?:\((.*?)\))?([\s\S]*?)@endsetup/s', function ($matches) {
            return $this->compileSetup(trim($matches[2]));
        }, $value);
    }

    protected function compileUncachedDirective($value)
    {
        return preg_replace_callback('/@uncached(?:\((.*?)\))?([\s\S]*?)@enduncached/s', function ($matches) {
            return $this->compileUncached(trim($matches[2]), $matches[1] ?? '');
        }, $value);
    }
}