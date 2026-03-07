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
    <rect fill="#fff"
          height="24"
          rx="4"
          ry="4"
          width="30"
          x="1"
          y="4"></rect>
    <path d="M1.244,6.67H30.756c-.55-1.552-2.016-2.67-3.756-2.67H5c-1.74,0-3.206,1.118-3.756,2.67Z" fill="#295cab">
    </path>
    <path d="M1 9.34H31V12.01H1z" fill="#295cab"></path>
    <path d="M1 14.68H31V17.35H1z" fill="#295cab"></path>
    <path d="M1 20.02H31V22.689999999999998H1z" fill="#295cab"></path>
    <path d="M1.253,25.36c.558,1.536,2.018,2.64,3.747,2.64H27c1.729,0,3.188-1.104,3.747-2.64H1.253Z" fill="#295cab">
    </path>
    <path d="M14.35,4H5c-2.209,0-4,1.791-4,4v9.35H14.35V4Z" fill="#295cab"></path>
    <path d="M1 9.34H14.35V12.01H1z" fill="#fff"></path>
    <path d="M1 9.34H14.35V12.01H1z"
          fill="#fff"
          transform="rotate(90 7.675 10.675)"></path>
    <path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z"
          opacity=".15"></path>
    <path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z"
          fill="#fff"
          opacity=".2"></path>
</svg>
