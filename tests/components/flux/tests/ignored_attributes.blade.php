@cached(['except' => 'wire:key'])

@props(['counter'])

@php($counter->increment())

<div {{ $attributes }}></div>