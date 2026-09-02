<?php

namespace Flux;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Http\Request;

class AssetManager
{
    protected static ?array $flagManifest = null;

    static function boot()
    {
        $instance = new static;

        $instance->registerAssetDirective();
        $instance->registerAssetRoutes();
    }

    public function registerAssetDirective()
    {
        Blade::directive('fluxScripts', function ($expression) {
            return <<<PHP
            <?php app('livewire')->forceAssetInjection(); ?>
            {!! app('flux')->scripts($expression) !!}
            PHP;
        });

        Blade::directive('fluxAppearance', function ($expression) {
            return <<<PHP
            {!! app('flux')->fluxAppearance($expression) !!}
            PHP;
        });
    }

    public function registerAssetRoutes()
    {
        Route::get('/flux/flux.js', [static::class, 'fluxJs']);
        Route::get('/flux/flux.min.js', [static::class, 'fluxMinJs']);
        Route::get('/flux/editor.css', [static::class, 'editorCss']);
        Route::get('/flux/editor.js', [static::class, 'editorJs']);
        Route::get('/flux/editor.min.js', [static::class, 'editorMinJs']);
        Route::get('/flux/flags/{country}', [static::class, 'flag'])
            ->where('country', '[A-Za-z]{2}')
            ->name('__flux.flag');
    }

    public function flag(string $country)
    {
        $country = strtoupper($country);

        abort_unless(static::hasFlag($country), 404);

        return $this->pretendResponseIsFile(
            __DIR__.'/../dist/flags/'.$country.'.svg',
            'image/svg+xml; charset=utf-8',
            ['X-Content-Type-Options' => 'nosniff'],
        );
    }

    public static function flagUrl(string $country): ?string
    {
        $country = strtoupper(trim($country));
        $hash = static::flagManifest()[$country] ?? null;

        if (! $hash) return null;

        // Following scripts(), editorScripts(), and editorStyles()
        // Related: https://github.com/livewire/flux/pull/2183
        return url(route('__flux.flag', ['country' => $country], false).'?id='.$hash);
    }

    public static function hasFlag(string $country): bool
    {
        return isset(static::flagManifest()[strtoupper(trim($country))]);
    }

    protected static function flagManifest(): array
    {
        return static::$flagManifest ??= json_decode(
            file_get_contents(__DIR__.'/../dist/flags/manifest.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        )['flags'];
    }

    public function fluxJs() {
        return Flux::pro()
            ? $this->pretendResponseIsFile(__DIR__.'/../../flux-pro/dist/flux.js', 'text/javascript')
            : $this->pretendResponseIsFile(__DIR__.'/../../flux/dist/flux-lite.min.js', 'text/javascript');
    }

    public function fluxMinJs() {
        return Flux::pro()
            ? $this->pretendResponseIsFile(__DIR__.'/../../flux-pro/dist/flux.min.js', 'text/javascript')
            : $this->pretendResponseIsFile(__DIR__.'/../../flux/dist/flux-lite.min.js', 'text/javascript');
    }

    public function editorCss() {
        if (! Flux::pro()) throw new \Exception('Flux Pro is required to use the Flux editor.');

        return $this->pretendResponseIsFile(__DIR__.'/../../flux-pro/dist/editor.css', 'text/css');
    }

    public function editorJs() {
        if (! Flux::pro()) throw new \Exception('Flux Pro is required to use the Flux editor.');

        return $this->pretendResponseIsFile(__DIR__.'/../../flux-pro/dist/editor.js', 'text/javascript');
    }

    public function editorMinJs() {
        if (! Flux::pro()) throw new \Exception('Flux Pro is required to use the Flux editor.');

        return $this->pretendResponseIsFile(__DIR__.'/../../flux-pro/dist/editor.min.js', 'text/javascript');
    }

    public static function scripts($options = [])
    {
        $manifest = Flux::pro()
            ? json_decode(file_get_contents(__DIR__.'/../../flux-pro/dist/manifest.json'), true)
            : json_decode(file_get_contents(__DIR__.'/../../flux/dist/manifest.json'), true);

        $versionHash = $manifest['/flux.js'];

        $nonce = isset($options) && isset($options['nonce']) ? ' nonce="' . $options['nonce'] . '"' : '';

        if (config('app.debug')) {
            return '<script src="'. url('/flux/flux.js?id='. $versionHash) . '" data-navigate-once' . $nonce . '></script>';
        } else {
            return '<script src="'. url('/flux/flux.min.js?id='. $versionHash) . '" data-navigate-once' . $nonce . '></script>';
        }
    }

    public static function fluxAppearance($options = [])
    {
        $nonce = isset($options) && isset($options['nonce']) ? ' nonce="' . $options['nonce'] . '"' : '';

        // Make scrollbars dark in dark mode...
        return <<<HTML
<style$nonce>
    :root.dark {
        color-scheme: dark;
    }
</style>
<script$nonce>
    window.Flux = {
        applyAppearance (appearance) {
            let applyDark = () => document.documentElement.classList.add('dark')
            let applyLight = () => document.documentElement.classList.remove('dark')

            if (appearance === 'system') {
                let media = window.matchMedia('(prefers-color-scheme: dark)')

                window.localStorage.removeItem('flux.appearance')

                media.matches ? applyDark() : applyLight()
            } else if (appearance === 'dark') {
                window.localStorage.setItem('flux.appearance', 'dark')

                applyDark()
            } else if (appearance === 'light') {
                window.localStorage.setItem('flux.appearance', 'light')

                applyLight()
            }
        }
    }

    window.Flux.applyAppearance(window.localStorage.getItem('flux.appearance') || 'system')
</script>
HTML;
    }

    public static function editorScripts($nonce = null)
    {
        $manifest = json_decode(file_get_contents(__DIR__.'/../../flux-pro/dist/manifest.json'), true);

        $versionHash = $manifest['/editor.js'];

        $nonceAttr = $nonce ? ' nonce="' . $nonce . '"' : '';

        if (config('app.debug')) {
            return '<script src="'. url('/flux/editor.js?id='. $versionHash) . '" defer' . $nonceAttr . '></script>';
        } else {
            return '<script src="'. url('/flux/editor.min.js?id='. $versionHash) . '" defer' . $nonceAttr . '></script>';
        }
    }

    public static function editorStyles($nonce = null)
    {
        $manifest = json_decode(file_get_contents(__DIR__.'/../../flux-pro/dist/manifest.json'), true);

        $versionHash = $manifest['/editor.css'];

        $nonceAttr = $nonce ? ' nonce="' . $nonce . '"' : '';

        return '<link rel="stylesheet" href="'. url('/flux/editor.css?id='. $versionHash) . '"' . $nonceAttr . '>';
    }

    public function pretendResponseIsFile($file, $contentType = 'application/javascript; charset=utf-8', $headers = [])
    {
        $lastModified = filemtime($file);

        return $this->cachedFileResponse($file, $contentType, $lastModified,
            fn ($cacheHeaders) => response()->file($file, array_merge($cacheHeaders, $headers)));
    }

    protected function cachedFileResponse($filename, $contentType, $lastModified, $downloadCallback)
    {
        $expires = strtotime('+1 year');
        $cacheControl = 'public, max-age=31536000';

        if ($this->matchesCache($lastModified)) {
            return response('', 304, [
                'Expires' => $this->httpDate($expires),
                'Cache-Control' => $cacheControl,
            ]);
        }

        $headers = [
            'Content-Type' => $contentType,
            'Expires' => $this->httpDate($expires),
            'Cache-Control' => $cacheControl,
            'Last-Modified' => $this->httpDate($lastModified),
        ];

        if (str($filename)->endsWith('.br')) {
            $headers['Content-Encoding'] = 'br';
        }

        return $downloadCallback($headers);
    }

    protected function matchesCache($lastModified)
    {
        $ifModifiedSince = app(Request::class)->header('if-modified-since');

        return $ifModifiedSince !== null && @strtotime($ifModifiedSince) === $lastModified;
    }

    protected function httpDate($timestamp)
    {
        return sprintf('%s GMT', gmdate('D, d M Y H:i:s', $timestamp));
    }
}
