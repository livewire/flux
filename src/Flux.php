<?php

namespace Flux;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Flux\FluxManager
 */
class Flux extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'flux';
    }
}
