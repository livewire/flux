@aware([ 'variant' ])

@props([
    'variant' => 'default',
])

<flux:delegate-component :component="'radio.variants.' . $variant">{{ $slot }}</flux:delegate-component>
