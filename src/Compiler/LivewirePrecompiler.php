<?php

namespace Flux\Compiler;

use Illuminate\Support\Str;

class LivewirePrecompiler
{
    public static function compile($template)
    {
        if (! Str::contains($template, 'FLUX_SWAP:BEGIN')) {
            return $template;
        }

        $pattern = '/\[FLUX_SWAP:BEGIN\s+([^\]]+)\](.*?)\[FLUX_SWAP:END\]/s';
        preg_match_all($pattern, $template, $matches, PREG_SET_ORDER);

        if (empty($matches)) {
            return $template;
        }

        foreach ($matches as $match) {
            $original = $match[0];
            $replacement = $match[1];
            $compiled = trim($match[2]);

            // It's important that there is no whitespace between the replacement and the PHP tag.
            $swap = <<<PHP
$replacement<?php
    \Flux\Flux::cache()->addSwap('$replacement', function (\$data) {
        extract(\$data);
        \$__env = \$__env ?? view();
        ob_start();
?>$compiled<?php
        return ob_get_clean();
    });
?>
PHP;

            $template = str_replace($original, $swap, $template);
        }

        return $template;
    }
}