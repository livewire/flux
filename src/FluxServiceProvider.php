<?php

namespace Flux;

use Flux\Compiler\ComponentCompiler;
use Flux\Compiler\FluxComponentDirectives;
use Flux\Compiler\TagCompiler;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Arr;
use Illuminate\View\ComponentSlot;

class FluxServiceProvider extends ServiceProvider
{
    protected $useCachingCompiler = true;

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
        $this->bootTagCompiler();
        $this->bootMacros();

        if ($this->useCachingCompiler) {
            $this->bootCacheCompilerDirectives();
            $this->bootCacheCompilerMacros();
        }

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

    public function bootTagCompiler()
    {
        $compilerClass = FluxTagCompiler::class;

        if ($this->useCachingCompiler) {
            $compilerClass = TagCompiler::class;
        }

        $compiler = new $compilerClass(
            app('blade.compiler')->getClassComponentAliases(),
            app('blade.compiler')->getClassComponentNamespaces(),
            app('blade.compiler')
        );

        $componentCompiler = new ComponentCompiler;
        $componentCompiler->outputOptimizations = $this->useCachingCompiler;

        app()->bind('flux.compiler', fn () => $compiler);

        app('blade.compiler')->prepareStringsForCompilationUsing(function ($in) use ($componentCompiler) {
            return $componentCompiler->compile($in);
        });

        app('blade.compiler')->precompiler(function ($in) use ($compiler) {
            return $compiler->compile($in);
        });
    }

    protected function bootCacheCompilerDirectives()
    {
        app('blade.compiler')->directive('fluxComponent', fn ($expression) => FluxComponentDirectives::compileFluxComponentClass($expression));
        app('blade.compiler')->directive('endFluxComponentClass', fn () => FluxComponentDirectives::compileEndFluxComponentClass());
        app('blade.compiler')->directive('fluxAware', fn ($expression) => FluxComponentDirectives::compileFluxAware($expression));
    }

    public function bootMacros()
    {
        app('view')::macro('getCurrentComponentData', function () {
            return $this->currentComponentData;
        });

        ComponentAttributeBag::macro('pluck', function ($key) {
            $result = $this->get($key);

            unset($this->attributes[$key]);

            return $result;
        });
    }

    protected function bootCacheCompilerMacros()
    {
        app('view')::macro('startFluxComponent', function ($view, array $data = []) {
            $this->componentStack[] = $view;

            $this->componentData[$this->currentComponent()] = $data;
            $this->slots[$this->currentComponent()] = [];
        });

        app('view')::macro('fluxComponentData', function () {

            $defaultSlot = new ComponentSlot(trim(ob_get_clean()));

            $slots = array_merge([
                '__default' => $defaultSlot,
            ], $this->slots[count($this->componentStack) - 1]);

            return array_merge(
                $this->componentData[count($this->componentStack) - 1],
                ['slot' => $defaultSlot],
                $this->slots[count($this->componentStack) - 1],
                ['__laravel_slots' => $slots]
            );
        });

        app('view')::macro('popFluxComponent', function () {
            array_pop($this->componentStack);
        });

        app('view')::macro('renderFluxComponent', function ($data) {
            $view = array_pop($this->componentStack);

            $this->currentComponentData = array_merge(
                $previousComponentData = $this->currentComponentData,
                $data
            );

            try {
                $view = value($view, $data);

                if ($view instanceof View) {
                    return $view->with($data)->render();
                } elseif ($view instanceof Htmlable) {
                    return $view->toHtml();
                } else {
                    return $this->make($view, $data)->render();
                }
            } finally {
                $this->currentComponentData = $previousComponentData;
            }
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
