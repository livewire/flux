@cached
@props([
    'value' => null,
    'counter',
])

@php($counter->increment())

<option
    {{ $attributes }}
    @uncached(['value'])
    @if (isset($value)) value="{{ $value }}" @endif
    @if (isset($value)) wire:key="{{ $value }}" @endif
    @enduncached
><flux:uncached>{{ $slot }}</flux:uncached></option>