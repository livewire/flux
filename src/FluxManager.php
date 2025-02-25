<?php

namespace Flux;

use Flux\Concerns\InteractsWithComponents;
use Composer\InstalledVersions;
use Illuminate\Support\Str;
use Flux\ClassBuilder;

use function Livewire\on;

class FluxManager
{
    use InteractsWithComponents;

    public $hasRenderedAssets = false;

    public function boot()
    {
        on('flush-state', function () {
            $this->hasRenderedAssets = false;
        });

        $this->bootComponents();
    }

    public function ensurePro()
    {
        if (! InstalledVersions::isInstalled('livewire/flux-pro')) {
            throw new \Exception('Your install of Flux is not activated. Visit https://fluxui.dev/pricing to purchase a license key.');
        }
    }

    public function pro()
    {
        return InstalledVersions::isInstalled('livewire/flux-pro');
    }

    public function markAssetsRendered()
    {
        $this->hasRenderedAssets = true;
    }

    public function styles($options = [])
    {
        $this->markAssetsRendered();

        return AssetManager::styles($options);
    }

    public function scripts($options = [])
    {
        $this->markAssetsRendered();

        return AssetManager::scripts($options);
    }

    public function editorStyles()
    {
        return AssetManager::editorStyles();
    }

    public function editorScripts()
    {
        return AssetManager::editorScripts();
    }

    public function classes($styles = null)
    {
        $builder = new ClassBuilder;

        return $styles ? $builder->add($styles) : $builder;
    }

    public function disallowWireModel($attributes, $componentName)
    {
        if ($attributes->whereStartsWith('wire:')->isNotEmpty()) {
            throw new \Exception('Cannot use wire:model on <'.$componentName.'>');
        }
    }

    public function splitAttributes($attributes, $by = ['class', 'style'], $strict = false)
    {
        return [
            $strict ? $attributes->only($by) : $attributes->whereStartsWith($by),
            $strict ? $attributes->except($by) : $attributes->whereDoesntStartWith($by),
        ];
    }

    // @deprecated - use extract(Flux::forwardedAttributes()) instead...
    public function restorePassThroughProps($attributes, $passThroughProps)
    {
        foreach ($passThroughProps as $passThroughProp) {
            $attributes = $attributes->except($passThroughProp)->merge([
                Str::camel($passThroughProp) => $attributes->get($passThroughProp),
            ]);
        }

        return $attributes;
    }

    public function forwardedAttributes($attributes, $propKeys)
    {
        $props = [];

        $unescape = fn ($value) => is_string($value) ? htmlspecialchars_decode($value, ENT_QUOTES) : $value;

        foreach ($propKeys as $key) {
            // Because Blade automatically escapes all "attributes" (not "props"), it errantly escaped these values.
            // Therefore, we have to apply an "unescape" operation (htmlspecialchars_decode) to rectify that...
            if (isset($attributes[$key])) {
                $props[$key] = $unescape($attributes[$key]);
            }
            // If a kebab-cased prop is present, we need to convert it to camelCase so that @props() picks it up...
            elseif (isset($attributes[Str::kebab($key)])) {
                $props[$key] = $unescape($attributes[Str::kebab($key)]);
            }
        }

        return $props;
    }

    public function applyInset($inset, $top, $right, $bottom, $left)
    {
        if ($inset === null) return '';

        $insets = $inset === true
            ? collect(['top', 'right', 'bottom', 'left'])
            : str($inset)->explode(' ')->map(fn ($i) => trim($i));

        $insetClasses = [
            'top' => $top,
            'right' => $right,
            'bottom' => $bottom,
            'left' => $left,
        ];

        return $insets->map(fn ($i) => $insetClasses[$i])->join(' ');
    }

    public function componentExists($name)
    {
        // Laravel 12+ uses xxh128 hashing for views https://github.com/laravel/framework/pull/52301...
        if (app()->version() >= 12) {
            return app('view')->exists(hash('xxh128', 'flux') . '::' . $name);
        }

        return app('view')->exists(md5('flux') . '::' . $name);
    }
}
