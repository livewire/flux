<?php Flux::cache(); ?>
@props([
    'value' => null,
])

<flux:nocache use="value">The Value: {{ $value }}</flux:nocache>
Slot: {{ $slot }}