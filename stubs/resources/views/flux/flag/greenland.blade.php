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
    <path d="m31,8c0-2.2092-1.7908-4-4-4H5c-2.2092,0-4,1.7908-4,4v9h30v-9Z"
          fill="#fff"
          stroke-width="0"></path>
    <path d="m5,28h22c2.2092,0,4-1.7908,4-4v-8H1v8c0,2.2092,1.7908,4,4,4Z"
          fill="#ca0a2b"
          stroke-width="0"></path>
    <path d="m5,28h22c2.2091,0,4-1.7908,4-4V8c0-2.2092-1.7909-4-4-4H5c-2.2092,0-4,1.7908-4,4v16c0,2.2092,1.7908,4,4,4ZM2,8c0-1.6543,1.3457-3,3-3h22c1.6543,0,3,1.3457,3,3v16c0,1.6543-1.3457,3-3,3H5c-1.6543,0-3-1.3457-3-3V8Z"
          opacity=".15"
          stroke-width="0"></path>
    <path d="m27,5H5c-1.6569,0-3,1.3431-3,3v1c0-1.6569,1.3431-3,3-3h22c1.6569,0,3,1.3431,3,3v-1c0-1.6569-1.3431-3-3-3Z"
          fill="#fff"
          opacity=".2"
          stroke-width="0"></path>
    <circle cx="11"
            cy="16"
            fill="#fff"
            r="6"
            stroke-width="0"></circle>
    <path d="m11,10c-3.3137,0-6,2.6863-6,6h12c0-3.3137-2.6863-6-6-6Z"
          fill="#ca0a2b"
          stroke-width="0"></path>
</svg>
