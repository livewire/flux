@blaze

{{-- Credit: Heroicons (https://heroicons.com) --}}

@props([
    'icon' => null,
    'name' => null,
])

@php
$icon = $name ?? $icon;
@endphp

<flux:delegate-component :component="'icon.' . $icon">{{ $slot }}</flux:delegate-component>
