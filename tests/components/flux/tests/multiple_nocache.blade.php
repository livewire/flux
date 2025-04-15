<?php Flux::cache(); ?>
@props([
    'value' => null,
    'counter',
])

@php($counter->increment())

<option
    {{ $attributes }}
    @nocache(['value'])
    @if (isset($value)) value="{{ $value }}" @endif
    @if (isset($value)) wire:key="{{ $value }}" @endif
    @endnocache
><flux:nocache>{{ $slot }}</flux:nocache></option>