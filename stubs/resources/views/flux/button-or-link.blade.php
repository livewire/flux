@props([
    'type' => 'button',
    'current' => null,
    'href' => null,
])

@php
$href = $href ? (string) str($href)->after(trim(config('app.url'), '/')) : $href;

if ($href === '') {
    $href = '/';
}

$current = $current === null ? ($href ? request()->is($href === '/' ? '/' : trim($href, '/')) : false) : $current;
@endphp

<?php if ($href): ?>
    {{-- We are using e() here to escape the href attribute value instead of "{{ }}" because the latter will escape the entire attribute value, including the "&" character... --}}
    <a href="{!! e($href) !!}" {{ $attributes->merge(['data-current' => $current]) }}>
        {{ $slot }}
    </a>
<?php else: ?>
    <button {{ $attributes->merge(['type' => $type, 'data-current' => $current]) }}>
        {{ $slot }}
    </button>
<?php endif; ?>
