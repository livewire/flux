@blaze(fold: true, unsafe: [
    // variant props
    'name', 'accent', 'size', 'label', 'icon', 'description', 'indicator',
    'icon:variant',
])

@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

@php
// This prevents variants picked up by `@aware()` from other wrapping components like flux::modal from being used here...
$variant = $variant !== 'default' && Flux::componentExists('checkbox.variants.' . $variant)
    ? $variant
    : 'default';
@endphp

<flux:delegate-component :component="'checkbox.variants.' . $variant">{{ $slot }}</flux:delegate-component>
