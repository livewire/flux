<?php Flux::shouldCache(); ?>
@props([
    'value' => null,
])

@nocache(['value'])

The Value: {{ $value }}
@endnocache
Slot: {{ $slot }}