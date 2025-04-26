@cached
@props([
    'value' => null,
])

<flux:uncached use="value">The Value: {{ $value }}</flux:uncached>
Slot: {{ $slot }}