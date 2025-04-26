@cached
@props([
    'value' => null,
])

<flux:uncached exclude="value">The Value: {{ $value }}</flux:uncached>
Slot: {{ $slot }}