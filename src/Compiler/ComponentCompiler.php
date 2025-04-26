<?php

namespace Flux\Compiler;

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
        $value = preg_replace('/(?<!@)@aware\(/', '@fluxAware(', $value);

        $value = $this->compileNoCacheMetaComponent($value);
        $value = $this->compileNocacheDirective($value);

        return $value;
    }

    protected function compileNoCache($content, $ignore)
    {
        $replacement = '__FLUX::SWAP_REPLACEMENT::'. Str::random();

        $compiledIgnore = '';

        if (strlen($ignore) > 0) {
            $compiledIgnore = "\Flux\Flux::cache()->ignore({$ignore});";
        }


        $swap = <<<'PHP'
<?php
    #ignore#
    \Flux\Flux::cache()->addSwap('$replacement', function ($data) {
        extract($data); ob_start(); ?>#body#<?php
        return ob_get_clean();
    });
?>$replacement
PHP;

        return Str::swap([
            '$replacement' => $replacement,
            '#body#' => $content,
            '#ignore#' => $compiledIgnore,
        ], $swap);
    }

    protected function compileNoCacheMetaComponent($value)
    {
        return preg_replace_callback('/<flux:nocache(?:\s+([^>]+))?>(.*?)<\/flux:nocache>/s', function ($matches) {
            $ignore = '';

            if ($matches[1]) {
                $attributes = $this->getAttributesFromAttributeString($matches[1]);

                if (isset($attributes['use'])) {
                    $variables = str(mb_substr($attributes['use'], 1, -1))
                        ->explode(',')
                        ->map(fn ($var) => "'{$var}'")
                        ->implode(', ');
                    $ignore = '['.$variables.']';
                }
            }

            return $this->compileNoCache($matches[2], $ignore);
        }, $value);
    }

    protected function compileNocacheDirective($value)
    {
        return preg_replace_callback('/@nocache(?:\((.*?)\))?([\s\S]*?)@endnocache/s', function ($matches) {
            return $this->compileNoCache(trim($matches[2]), $matches[1] ?? '');
        }, $value);
    }
}