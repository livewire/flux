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
            $replacementMarker = $match[1];
            $compiled = trim($match[2]);
            $compileMarker = "[FLUX_SWAP:COMPILED $replacementMarker]";

            $template = Str::swap([
                $original => $replacementMarker,
                $compileMarker => $compiled,
            ], $template);
        }

        return $template;
    }
}