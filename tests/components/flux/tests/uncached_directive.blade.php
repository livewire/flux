@cached
@props([
    'value' => null,
])

@uncached(['value'])

The Value: {{ $value }}
@enduncached
Slot: {{ $slot }}