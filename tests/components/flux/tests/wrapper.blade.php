@props([
    'counter',
])

@php($counter->increment())

{{ $slot }}