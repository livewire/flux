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
          height="10"
          stroke-width="0"
          width="30"
          x="1"
          y="11"></rect>
    <path d="m5,4h22c2.2077,0,4,1.7923,4,4v4H1v-4c0-2.2077,1.7923-4,4-4Z"
          fill="#027b3b"
          stroke-width="0"></path>
    <path d="m5,20h22c2.2077,0,4,1.7923,4,4v4H1v-4c0-2.2077,1.7923-4,4-4Z"
          stroke-width="0"
          transform="translate(32 48) rotate(180)"></path>
    <path d="m27,4H5c-2.2091,0-4,1.7908-4,4v16c0,2.2092,1.7909,4,4,4h22c2.2092,0,4-1.7908,4-4V8c0-2.2092-1.7908-4-4-4Zm3,20c0,1.6543-1.3457,3-3,3H5c-1.6543,0-3-1.3457-3-3V8c0-1.6543,1.3457-3,3-3h22c1.6543,0,3,1.3457,3,3v16Z"
          opacity=".15"
          stroke-width="0"></path>
    <path d="m27,5H5c-1.6569,0-3,1.3431-3,3v1c0-1.6569,1.3431-3,3-3h22c1.6569,0,3,1.3431,3,3v-1c0-1.6569-1.3431-3-3-3Z"
          fill="#fff"
          opacity=".2"
          stroke-width="0"></path>
    <polygon fill="#cf0822"
             points="9.0346 16.551 11 15.123 8.5706 15.123 7.8199 12.8125 7.0692 15.123 4.6398 15.123 6.6052 16.551 5.8545 18.8614 7.8199 17.4335 9.7853 18.8614 9.0346 16.551"
             stroke-width="0"></polygon>
    <polygon fill="#cf0822"
             points="17.2147 16.551 19.1801 15.123 16.7507 15.123 16 12.8125 15.2493 15.123 12.8199 15.123 14.7853 16.551 14.0346 18.8614 16 17.4335 17.9654 18.8614 17.2147 16.551"
             stroke-width="0"></polygon>
    <polygon fill="#cf0822"
             points="22.9654 16.551 21 15.123 23.4294 15.123 24.1801 12.8125 24.9308 15.123 27.3602 15.123 25.3948 16.551 26.1455 18.8614 24.1801 17.4335 22.2147 18.8614 22.9654 16.551"
             stroke-width="0"></polygon>
</svg>
