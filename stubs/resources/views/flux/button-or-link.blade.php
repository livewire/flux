@props([
    'type' => 'button',
    'current' => null,
    'href' => null,
])

@php
$appUrl = str(config('app.url'))->rtrim('/');
$href = $href ? ((string) str($href)->after($appUrl)->rtrim('/') === '' ? '/' : (string) str($href)->after($appUrl)->rtrim('/')) : $href;

$current = $current === null ? ($href ? request()->is($href === '/' ? '/' : trim($href, '/')) : false) : $current;
@endphp

<?php if ($href): ?>
    <a href="{{ $href }}" {{ $attributes->merge(['data-current' => $current]) }}>
        {{ $slot }}
    </a>
<?php else: ?>
    <button {{ $attributes->merge(['type' => $type]) }}>
        {{ $slot }}
    </button>
<?php endif; ?>
