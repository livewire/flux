@props([
    'type' => 'button',
    'variant' => null,
    'current' => null,
    'href' => null,
])

@php
$href = str($href)->startsWith(trim(config('app.url')))
    ? (string) str($href)->after(trim(config('app.url'), '/'))
    : $href;

if ($href === '') $href = '/';

$current = $current === null ? ($href
    ? request()->is($href === '/' ? '/' : trim($href, '/'))
    : false) : $current;
@endphp

<?php if ($href): ?>
    {{-- We are using e() here to escape the href attribute value instead of "{{ }}" because the latter will escape the entire attribute value, including the "&" character... --}}
    <a href="{!! e($href) !!}" {{ $attributes->merge(['data-current' => $current, 'data-variant' => $variant]) }}>
        {{ $slot }}
    </a>
<?php else: ?>
    <button {{ $attributes->merge(['type' => $type, 'data-current' => $current, 'data-variant' => $variant]) }}>
        {{ $slot }}
    </button>
<?php endif; ?>
