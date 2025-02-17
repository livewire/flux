@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

@php
$variant = Flux::componentExists('checkbox.variants.' . $variant) ? $variant : 'default';
@endphp

<flux:delegate-component :component="'checkbox.variants.' . $variant">{{ $slot }}</flux:delegate-component>
