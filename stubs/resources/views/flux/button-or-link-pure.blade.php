@blaze

@php
extract(Flux::forwardedAttributes($attributes, [
    'type',
    'href',
    'as',
]));
@endphp

@props([
    'type' => 'button',
    'href' => null,
    'as' => null,
])

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
