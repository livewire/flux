@props([
    'variant' => 'default',
])

<flux:delegate-component :component="'checkbox.group.variants.' . $variant">{{ $slot }}</flux:delegate-component>
