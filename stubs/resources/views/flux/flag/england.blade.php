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
    <rect x="1" y="4" width="30" height="24" rx="4" ry="4" fill="#fff"></rect>
    <path fill="#be2a2a" d="M31 14L18 14 18 4 14 4 14 14 1 14 1 18 14 18 14 28 18 28 18 18 31 18 31 14z"></path>
    <path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z" opacity=".15"></path>
    <path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z" fill="#fff" opacity=".2"></path>
</svg>
