@props([
    'variant' => 'default',
])

<flux:delegate-component :component="'radio.group.variants.' . $variant">{{ $slot }}</flux:delegate-component>
