@cached
@props([
    'counter',
])

@php($counter->increment())

<flux:uncached>{{ $slot }}</flux:uncached>