<?php

namespace Flux\Tests;

use Flux\FluxServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase;

class FluxTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            FluxServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('view:clear');
        Blade::anonymousComponentPath(__DIR__.'/components/blade/');
        Blade::anonymousComponentPath(__DIR__.'/components/flux/', 'flux');
    }

    protected function render($template, $data = [])
    {
        return Blade::render($template, $data, true);
    }
}