<?php Flux::shouldCache(); ?>
@props([
    'counter',
])

@php($counter->increment())

<flux:nocache>{{ $slot }}</flux:nocache>