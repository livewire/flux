@blaze(fold: true)

@props([
    'size' => 'base'
])

@php
$classes = Flux::classes('shrink-0')
    ->add(match($size) {
        'xl' => '[:where(&)]:size-16',
        'lg' => '[:where(&)]:size-12',
        'base' => '[:where(&)]:size-8',
    });
@endphp

<svg {{ $attributes->class($classes) }} data-flux-flag xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" data-slot="flag">
    <!-- SVG for Tanzania -->
</svg>
