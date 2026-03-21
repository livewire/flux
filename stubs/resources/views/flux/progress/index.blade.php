@blaze(fold: true)

@props([
    'variant' => 'default',
    'circular' => null,
])

@php
$variant = $circular ? 'circular' : $variant;

$variant = $variant !== 'default' && Flux::componentExists('progress.variants.' . $variant)
    ? $variant
    : 'default';
@endphp

<flux:delegate-component :component="'progress.variants.' . $variant">{{ $slot }}</flux:delegate-component>
