@blaze(fold: true)

@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

@php
$variant = $variant !== 'default' && Flux::componentExists('select.variants.' . $variant)
    ? 'custom'
    : 'default';
@endphp

<flux:delegate-component :component="'select.group.variants.' . $variant">{{ $slot }}</flux:delegate-component>
