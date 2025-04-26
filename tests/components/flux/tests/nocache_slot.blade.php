<?php Flux::shouldCache(); ?>
@props(['counter'])

@php($counter->increment())

{{ $slot }}