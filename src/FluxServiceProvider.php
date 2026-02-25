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
        $this->callAfterResolving('blade.compiler', function ($blade) {
            $this->bootComponentPath($blade);
            $this->bootFallbackBlazeDirectivesIfBlazeIsNotInstalled($blade);
            $this->bootTagCompiler($blade);

            AssetManager::bootDirectives();
        });

        AssetManager::bootRoutes();

        $this->app->booted(function () {
            $this->bootMacros();

            app('livewire')->propertySynthesizer(DateRangeSynth::class);

            app('flux')->boot();
        });

        $this->bootCommands();
    }

    public function bootComponentPath($blade)
    {
        if (file_exists(resource_path('views/flux'))) {
            $blade->anonymousComponentPath(resource_path('views/flux'), 'flux');
        }

        $blade->anonymousComponentPath(__DIR__.'/../stubs/resources/views/flux', 'flux');
    }

    public function bootFallbackBlazeDirectivesIfBlazeIsNotInstalled($blade)
    {
        $blade->directive('blaze', fn () => '');

        // `@pure` directive has been replaced with `@blaze` in Blaze v1.0, but we need to keep it here for
        // backwards compatibility as people could have published components or custom icons using it...
        $blade->directive('pure', fn () => '');

        $blade->directive('unblaze', function ($expression) {
            return ''
                . '<'.'?php $__getScope = fn($scope = []) => $scope; ?>'
                . '<'.'?php if (isset($scope)) $__scope = $scope; ?>'
                . '<'.'?php $scope = $__getScope('.$expression.'); ?>';
        });

        $blade->directive('endunblaze', function () {
            return '<'.'?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>';
        });
    }

    public function bootTagCompiler($blade)
    {
        $compiler = null;

        $this->app->bind('flux.compiler', function () use (&$compiler, $blade) {
            return $compiler ??= new FluxTagCompiler(
                $blade->getClassComponentAliases(),
                $blade->getClassComponentNamespaces(),
                $blade
            );
        });

        $blade->precompiler(function ($in) use (&$compiler, $blade) {
            $compiler ??= new FluxTagCompiler(
                $blade->getClassComponentAliases(),
                $blade->getClassComponentNamespaces(),
                $blade
            );

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
