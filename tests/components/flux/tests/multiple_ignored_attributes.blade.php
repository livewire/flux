@cached(['except' => ['wire:key', 'key']])

@props(['counter'])

@php($counter->increment())

<div {{ $attributes }}></div>