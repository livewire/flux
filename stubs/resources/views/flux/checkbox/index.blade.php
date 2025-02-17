@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

<flux:delegate-component :component="'checkbox.variants.' . $variant">{{ $slot }}</flux:delegate-component>
