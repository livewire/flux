<?php

namespace Flux\Compiler;

use Flux\Flux;
use Flux\Support\StrUtil;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;

class ComponentCompiler extends ComponentTagCompiler
{
    protected $hoistedContent = '';

    public function isFluxComponent($value)
    {
        return Str::startsWith(ltrim($value), ['@cached', '@optimized']);
    }

    protected function compileOptimizedComponent($value)
    {
        $this->hoistedContent = '';

        $value = StrUtil::normalizeLineEndings($value);

        // If the Flux component contains @aware or @props, we need
        // to make sure we insert our @uncached directive pair
        // after them. Otherwise, we will be missing info
        // later on, which will lead to state errors
        //
        // This error presents itself as "undefined array key index ''"
        $value = ltrim(preg_replace('/(?<!@)@optimized/', '', $value));
        preg_match_all('/(?<!@)@(props|aware)\(/', $value, $matches, PREG_OFFSET_CAPTURE);

        if (count($matches[1] ?? []) === 0) {
            return "<?php Flux::shouldOptimize(); ?>\n@uncached\n$value\n@enduncached";
        }

        $matches = $matches[1];

        // Get the offset of the first interesting directive.
        $firstMatchOffset = $matches[0][1];

        // Find anything interesting we may want to hoist
        $this->hoistedContent = (string) str($value)
            ->substr(0, $firstMatchOffset - 1)
            ->trim();

        // Get the offset of the last directive we are interested in
        $lastMatchOffset = $matches[array_key_last($matches)][1];

        $startLine = str($value)
            ->substr(0, $lastMatchOffset) // Limit the search space to the start of the last important directive.
            ->substrCount("\n"); // Find the 0-indexed line number of the directive.

        // Now that we have the line our directive starts on, we need to find the ending of it.
        $lines = explode("\n", $value);
        $endLine = null;

        for ($i = $startLine; $i < count($lines); $i++) {
            $line = (string) str($lines[$i])
                ->squish(); // Collapse the whitespace to make finding our ending easier.

            if (Str::endsWith($line, ['])', '] )'])) {
                $endLine = $i;
                break;
            }
        }

        if ($endLine === null) {
            return $value;
        }

        // Insert the beginning of our uncached directive.
        array_splice(
            $lines,
            $endLine, 1,
            [ $lines[$endLine], '@uncached' ]
        );

        $lines[] = '@enduncached';

        // Add our shouldOptimize call.
        array_unshift($lines, '<?php Flux::shouldOptimize(); ?>');

        return implode("\n", $lines);
    }

    public function compile($value)
    {
        if (! $value) {
            return $value;
        }

        if (! $this->isFluxComponent($value)) {
            return $value;
        }

        if (Str::startsWith(ltrim($value), '@optimized')) {
            $value = $this->compileOptimizedComponent($value);
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
        \$__env = \$__env ?? view();
        \$attributes ??= new \\Illuminate\\View\\ComponentAttributeBag;

?>{$this->hoistedContent}<?php

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