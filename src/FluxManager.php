<?php

namespace Flux;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Flux\Concerns\InteractsWithComponents;
use Composer\InstalledVersions;
use Illuminate\Support\Str;
use Flux\ClassBuilder;

use function Livewire\on;

class FluxManager
{
    use InteractsWithComponents;

    public $hasRenderedAssets = false;

    protected $nonce = null;

    protected $codeHighlighter = null;

    protected $codeHighlighterResolved = false;

    public function boot()
    {
        on('flush-state', function () {
            $this->hasRenderedAssets = false;
            $this->nonce = null;
        });

        $this->bootComponents();
    }

    public function ensurePro()
    {
        if (! $this->pro()) {
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

    public function nonce()
    {
        return $this->nonce ?? \Illuminate\Support\Facades\Vite::cspNonce();
    }

    public function scripts($options = [])
    {
        $this->markAssetsRendered();

        if (isset($options['nonce'])) {
            $this->nonce = $options['nonce'];
        }

        return AssetManager::scripts($options);
    }

    public function fluxAppearance($options = [])
    {
        $this->markAssetsRendered();

        if (isset($options['nonce'])) {
            $this->nonce = $options['nonce'];
        }

        return AssetManager::fluxAppearance($options);
    }

    public function editorStyles()
    {
        return AssetManager::editorStyles($this->nonce());
    }

    public function editorScripts()
    {
        return AssetManager::editorScripts($this->nonce());
    }

    public function classes($styles = null)
    {
        $builder = new ClassBuilder;

        return $styles ? $builder->add($styles) : $builder;
    }

    public function codeHighlighter(?callable $highlighter)
    {
        $this->codeHighlighter = $highlighter;
        $this->codeHighlighterResolved = true;

        return $this;
    }

    public function highlightCode(string $code, string $language = 'text', ?string $highlight = null): HtmlString
    {
        if (! $this->codeHighlighterResolved) {
            $this->codeHighlighter = class_exists(\Phiki\Phiki::class)
                ? new Code\PhikiHighlighter
                : null;

            $this->codeHighlighterResolved = true;
        }

        if ($this->codeHighlighter) {
            $html = ($this->codeHighlighter)($code, $language, $highlight);

            if ($html !== null) {
                return new HtmlString($html instanceof Htmlable ? $html->toHtml() : (string) $html);
            }
        }

        return new HtmlString($this->renderPlainCode($code, $language, $highlight));
    }

    protected function renderPlainCode(string $code, string $language, ?string $highlight): string
    {
        $language = preg_replace('/[^a-z0-9_+-]/', '', strtolower($language)) ?: 'text';
        $highlights = Code\CodeHighlights::parse($highlight);

        $codeLines = preg_split('/\R/u', $code);

        $lines = array_map(function ($line, $index) use ($highlights) {
            $number = $index + 1;
            $classes = $highlights->includesLine($number) ? 'line highlight highlight-line' : 'line';
            $content = implode('', array_map(
                fn ($segment) => $segment[1]
                    ? '<span class="highlight highlight-characters">'.e($segment[0]).'</span>'
                    : e($segment[0]),
                $highlights->segments($line, $number),
            ));

            return '<span class="'.$classes.'">'.$content.'</span>';
        }, $codeLines, array_keys($codeLines));

        return '<pre data-flux-code-pre><code class="language-'.$language.'">'.implode('', $lines).'</code></pre>';
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

    public function attributesAfter($prefix, $attributes, $default = [])
    {
        $newAttributes = new \Illuminate\View\ComponentAttributeBag($default);
        $keysToRemove = [];

        foreach ($attributes->getAttributes() as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $newAttributes[substr($key, strlen($prefix))] = $value;
                $keysToRemove[] = $key;
            }
        }

        // Remove the transferred attributes from the original bag
        foreach ($keysToRemove as $key) {
            unset($attributes[$key]);
        }

        return $newAttributes;
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
