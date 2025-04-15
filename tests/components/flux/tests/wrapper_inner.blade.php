<?php Flux::cache(); ?>
@props([
    'counter',
])

@php($counter->increment())

<flux:nocache>{{ $slot }}</flux:nocache>