@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

@php
$variant = Flux::componentExists('radio.variants.' . $variant) ? $variant : 'default';
@endphp

<flux:delegate-component :component="'radio.variants.' . $variant">{{ $slot }}</flux:delegate-component>
