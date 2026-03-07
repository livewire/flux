@blaze(fold: true)

{{-- Credit: Nucleo App (https://nucleoapp.com/svg-flag-icons) --}}

@props([
    'size' => 'base',
])

@php
    $classes = Flux::classes('shrink-0')->add(
        match ($size) {
            'xl' => '[:where(&)]:size-16',
            'lg' => '[:where(&)]:size-12',
            'base' => '[:where(&)]:size-8',
        },
    );
@endphp

<svg {{ $attributes->class($classes) }}
     data-flux-flag
     data-slot="flag"
     viewBox="0 0 32 32"
     xmlns="http://www.w3.org/2000/svg">
    <path d="M10 4H22V28H10z" fill="#2b65ae"></path>
    <path d="M5,4h6V28H5c-2.208,0-4-1.792-4-4V8c0-2.208,1.792-4,4-4Z" fill="#c93336"></path>
    <path d="M25,4h6V28h-6c-2.208,0-4-1.792-4-4V8c0-2.208,1.792-4,4-4Z"
          fill="#c93336"
          transform="rotate(180 26 16)"></path>
    <path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z"
          opacity=".15"></path>
    <path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z"
          fill="#fff"
          opacity=".2"></path>
    <circle cx="6"
            cy="11.656"
            fill="#f7d448"
            r="1.528"></circle>
    <path d="M3 13.455H4.364V20H3z" fill="#f7d448"></path>
    <path d="M7.636 13.455H9V20H7.636z" fill="#f7d448"></path>
    <path d="M4.636 13.455L7.364 13.455 6 14.273 4.636 13.455z" fill="#f7d448"></path>
    <path d="M4.636 14.545H7.3629999999999995V15.09H4.636z" fill="#f7d448"></path>
    <path d="M4.636 18.364H7.3629999999999995V18.909000000000002H4.636z" fill="#f7d448"></path>
    <path d="M4.636 19.182L7.364 19.182 6 20 4.636 19.182z" fill="#f7d448"></path>
    <circle cx="6"
            cy="16.727"
            fill="#f7d448"
            r="1.364"></circle>
</svg>
