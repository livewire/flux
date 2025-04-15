<?php Flux::cache(); ?>
@props([
    'value' => null,
])

@nocache(['value'])

The Value: {{ $value }}
@endnocache
Slot: {{ $slot }}