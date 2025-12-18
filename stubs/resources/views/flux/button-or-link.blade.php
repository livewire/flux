@php
extract(Flux::forwardedAttributes($attributes, [
    'type',
    'current',
    'href',
    'as',
]));
@endphp

@props([
    'type' => 'button',
    'current' => null,
    'href' => null,
    'as' => null,
])

@php
if ($as !== 'div' || $href) {
    if ($current !== null) {
        // If the user manually specified :current="true/false", we need to stop Livewire from managing
        // the data-current attribute as it would be automatically added/removed when using wire:navigate...
        $attributes = $attributes->merge(['data-current' => $current, 'wire:current.ignore' => true]);
    } else {
        $hrefForCurrentDetection = str($href)->startsWith(trim(config('app.url')))
            ? (string) str($href)->after(trim(config('app.url'), '/'))
            : $href;

        if ($hrefForCurrentDetection === '') $hrefForCurrentDetection = '/';

        $requestIs = function ($pattern) {
            // Support current route detection during Livewire update requests as well...
            return app('livewire')?->isLivewireRequest()
                ? str()->is($pattern, app('livewire')->originalPath())
                : request()->is($pattern);
        };

        $current = $hrefForCurrentDetection
            ? $requestIs($hrefForCurrentDetection === '/' ? '/' : trim($hrefForCurrentDetection, '/'))
            : false;

        $attributes = $attributes->merge(['data-current' => $current]);
    }
}
@endphp

<?php if ($as === 'div' && ! $href): ?>
    <div {{ $attributes }}>
        {{ $slot }}
    </div>
<?php elseif ($as === 'a' || $href): ?>
    {{-- We are using e() here to escape the href attribute value instead of "{{ }}" because the latter will escape the entire attribute value, including the "&" character... --}}
    <a href="{!! e($href) !!}" {{ $attributes }}>
        {{ $slot }}
    </a>
<?php else: ?>
    <button {{ $attributes->merge(['type' => $type]) }}>
        {{ $slot }}
    </button>
<?php endif; ?>
