<?php

namespace Flux\Compiler;

use Illuminate\Support\Str;

class OptimizedComponentCompiler
{
    protected static function compileSimpleOptimized($value)
    {
        $value = ltrim(preg_replace('/(?<!@)@optimized/', '', $value));

        return "<?php Flux::shouldOptimize(); ?>\n@uncached\n$value\n@enduncached";
    }

    public static function compile($value)
    {
        if (Str::contains($value, ['@endsetup', '<flux:setup'])) {
            // This component should already have everything it needs.
            if (Str::contains($value, ['@enduncached', '<flux:uncached'])) {
                return $value;
            }

            $search = '@endsetup';

            if (Str::contains($value, '</flux:setup>')) {
                $search = '</flux:setup>';
            }

            $value = ltrim(preg_replace('/(?<!@)@optimized/', '', $value));
            $value = str_replace($search, $search."\n@uncached\n", $value);

            return "<?php Flux::shouldOptimize(); ?>".$value."\n@enduncached";
        }

        if (! Str::contains($value, ['@props', '@aware'])) {
            return self::compileSimpleOptimized($value);
        }

        $directive = '@optimized';

        $originalValue = $value;

        $value = str($value)
            ->replaceMatches('/\r\n|\r|\n/', "\n")
            ->substr(strlen($directive));

        preg_match_all(
            '/(?<!@)@(props|aware)\(/',
            (string) $value,
            $allMatches,
            PREG_OFFSET_CAPTURE
        );

        if (empty($allMatches[0])) {
            return $originalValue;
        }

        $lastDirective = end($allMatches[1]);

        $startingLineNumber = $value->substr(0, $lastDirective[1])
            ->substrCount("\n");

        // Find ending line number.
        $endingLineNumber = null;

        $lines = $value->split('/\r\n|\r|\n/')->all();
        for ($i = $startingLineNumber; $i < count($lines); $i++) {
            $line = Str::squish($lines[$i]);

            if (Str::endsWith($line, ['])', '] )'])) {
                $endingLineNumber = $i;
                break;
            }
        }

        if ($endingLineNumber === null) {
            return $originalValue;
        }

        // Insert our endsetup and uncached directives.
        array_splice($lines, $endingLineNumber, 1, [
            $lines[$endingLineNumber],
            '@endsetup',
            '@uncached',
        ]);

        // Insert our leading directives.
        array_unshift($lines, '<?php Flux::shouldOptimize(); ?>', '@setup');

        $lines[] = '@enduncached';

        return implode("\n", $lines);
    }
}