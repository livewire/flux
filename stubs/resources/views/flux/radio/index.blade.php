@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

@php
// This prevents variants picked up by `@aware()` from other wrapping components like flux::modal from being used here...
$variant = $variant !== 'default' && Flux::componentExists('radio.variants.' . $variant)
    ? $variant
    : 'default';
@endphp

<flux:delegate-component :component="'radio.variants.' . $variant">{{ $slot }}</flux:delegate-component>
