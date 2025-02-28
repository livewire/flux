@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

@php
// This prevents variants picked up by `@aware()` from other wrapping components like flux::modal from being used here...
$variant = $variant !== 'default' && Flux::componentExists('select.variants.' . $variant)
    ? 'custom'
    : 'default';
@endphp

<flux:with-field :$attributes>
    <flux:delegate-component :component="'select.option.variants.' . $variant">{{ $slot }}</flux:delegate-component>
</flux:with-field>
