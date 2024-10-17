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

    public function styles()
    {
        $this->markAssetsRendered();

        return AssetManager::styles();
    }

    public function scripts()
    {
        $this->markAssetsRendered();

        return AssetManager::scripts();
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

    public function splitAttributes($attributes, $by = ['class', 'style'])
    {
        return [
            $attributes->only($by),
            $attributes->except($by),
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

        foreach ($propKeys as $key) {
            // Because Blade automatically escapes all "attributes" (not "props"), it errantly escaped these values.
            // Therefore, we have to apply an "unescape" operation (htmlspecialchars_decode) to rectify that...
            if (isset($attributes[$key])) {
                $props[$key] = htmlspecialchars_decode($attributes[$key], ENT_QUOTES);
            }
            // If a kebab-cased prop is present, we need to convert it to camelCase so that @props() picks it up...
            elseif (isset($attributes[Str::kebab($key)])) {
                $props[$key] = htmlspecialchars_decode($attributes[Str::kebab($key)], ENT_QUOTES);
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
        return app('view')->exists(md5('flux') . '::' . $name);
    }
}
