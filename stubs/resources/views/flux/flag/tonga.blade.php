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
    <rect fill="#b22518"
          height="24"
          rx="4"
          ry="4"
          width="30"
          x="1"
          y="4"></rect>
    <path d="M5,4H16v12H1V8c0-2.208,1.792-4,4-4Z" fill="#fff"></path>
    <path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z"
          opacity=".15"></path>
    <path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z"
          fill="#fff"
          opacity=".2"></path>
    <path d="M7.5 6.5H10V14H7.5z" fill="#b22518"></path>
    <path d="M7.5 6.5H10V14H7.5z"
          fill="#b22518"
          transform="rotate(90 8.75 10.25)"></path>
</svg>
