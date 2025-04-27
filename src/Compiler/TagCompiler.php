<?php

namespace Flux\Compiler;

use Flux\FluxTagCompiler;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\AnonymousComponent;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Illuminate\View\DynamicComponent;

class TagCompiler extends FluxTagCompiler
{
    protected $componentDirective = 'fluxComponent';

    protected $endComponentDirective = 'endFluxComponentClass';
}
