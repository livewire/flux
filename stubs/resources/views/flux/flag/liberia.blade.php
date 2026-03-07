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
    <path d="M1.456,6.182H30.544c-.664-1.29-1.993-2.182-3.544-2.182H5c-1.551,0-2.88,.892-3.544,2.182Z" fill="#b12532">
    </path>
    <path d="M1 8.364H31V10.546000000000001H1z" fill="#b12532"></path>
    <path d="M1 12.727H31V14.909H1z" fill="#b12532"></path>
    <path d="M1 17.091H31V19.273H1z" fill="#b12532"></path>
    <path d="M1 21.454H31V23.636H1z" fill="#b12532"></path>
    <path d="M30.544,25.818H1.456c.664,1.29,1.993,2.182,3.544,2.182H27c1.551,0,2.88-.892,3.544-2.182Z" fill="#b12532">
    </path>
    <path d="M5,4h6.909V14.909H1v-6.909c0-2.208,1.792-4,4-4Z" fill="#0b2364"></path>
    <path d="M27,4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4Zm3,20c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24Z"
          opacity=".15"></path>
    <path d="M7.455 10.043L9.074 8.867 7.073 8.867 6.455 6.964 5.836 8.867 3.836 8.867 5.454 10.043 4.836 11.945 6.455 10.769 8.073 11.945 7.455 10.043z"
          fill="#fff"></path>
    <path d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z"
          fill="#fff"
          opacity=".2"></path>
</svg>
