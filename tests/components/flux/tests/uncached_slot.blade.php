@cached
@props(['counter'])

@php($counter->increment())

{{ $slot }}