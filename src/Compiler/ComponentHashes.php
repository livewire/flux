<?php

namespace Flux\Compiler;

use Illuminate\View\Compilers\BladeCompiler;

class ComponentHashes extends BladeCompiler
{
    public static function newComponentHash(string $component)
    {
        return parent::newComponentHash($component);
    }

    public static function popHash()
    {
        return array_pop(static::$componentHashStack);
    }
}