<?php

namespace Flux;

use Illuminate\View\ComponentAttributeBag;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Arr;

class FluxServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->alias(FluxManager::class, 'flux');

        $this->app->singleton(FluxManager::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Flux', \Flux\Flux::class);
    }

    public function boot(): void
    {
        $this->bootComponentPath();
        $this->bootPureDirective();
        $this->bootTagCompiler();
        $this->bootMacros();

        app('livewire')->propertySynthesizer(DateRangeSynth::class);

        AssetManager::boot();

        app('flux')->boot();

        $this->bootCommands();
    }

    public function bootComponentPath()
    {
        if (file_exists(resource_path('views/flux'))) {
            Blade::anonymousComponentPath(resource_path('views/flux'), 'flux');
        }

        Blade::anonymousComponentPath(__DIR__.'/../stubs/resources/views/flux', 'flux');
    }

    public function bootPureDirective()
    {
        Blade::directive('pure', fn () => '');
    }

    public function bootTagCompiler()
    {
        $compiler = new FluxTagCompiler(
            app('blade.compiler')->getClassComponentAliases(),
            app('blade.compiler')->getClassComponentNamespaces(),
            app('blade.compiler')
        );

        app()->bind('flux.compiler', fn () => $compiler);

        app('blade.compiler')->precompiler(function ($in) use ($compiler) {
            return $compiler->compile($in);
        });
    }

    public function bootMacros()
    {
        app('view')::macro('getCurrentComponentData', function () {
            return $this->currentComponentData;
        });

        ComponentAttributeBag::macro('pluck', function ($key, $default = null) {
            $result = $this->get($key);

            unset($this->attributes[$key]);

            return $result ?? $default;
        });
    }

    public function bootCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\ActivateCommand::class,
            Console\PublishCommand::class,
            Console\IconCommand::class,
        ]);
    }
}
