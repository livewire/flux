@blaze(fold: true, unsafe: [
    // variant props
    'size',
    // flux:with-field props
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@aware([ 'variant', 'size', 'indicator' ])

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
