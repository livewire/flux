@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

@php
// If the variant is coming from the parent component and is not default, we need to use the custom variant...
$variant = $variant === 'default' ? 'default' : 'custom';
@endphp

<flux:with-field :$attributes>
    <flux:delegate-component :component="'select.option.variants.' . $variant">{{ $slot }}</flux:delegate-component>
</flux:with-field>
