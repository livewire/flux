<?php Flux::cache(); ?>
@props(['counter'])

@php($counter->increment())

{{ $slot }}