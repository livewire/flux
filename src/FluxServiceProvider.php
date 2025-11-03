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
        $this->bootFallbackBlazeDirectivesIfBlazeIsNotInstalled();
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

    public function bootFallbackBlazeDirectivesIfBlazeIsNotInstalled()
    {
        Blade::directive('blaze', fn () => '');

        // `@pure` directive has been replaced with `@blaze` in Blaze v1.0, but we need to keep it here for
        // backwards compatibility as people could have published components or custom icons using it...
        Blade::directive('pure', fn () => '');

        Blade::directive('unblaze', function ($expression) {
            return ''
                . '<'.'?php $__getScope = fn($scope = []) => $scope; ?>'
                . '<'.'?php if (isset($scope)) $__scope = $scope; ?>'
                . '<'.'?php $scope = $__getScope('.$expression.'); ?>';
        });

        Blade::directive('endunblaze', function () {
            return '<'.'?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>';
        });
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
