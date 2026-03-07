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
          stroke-width="0"
          width="30"
          x="1"
          y="4"></rect>
    <rect fill="#dd1216"
          height="24"
          stroke-width="0"
          width="8"
          x="12"
          y="4"></rect>
    <rect fill="#022588"
          height="30"
          stroke-width="0"
          transform="translate(32) rotate(90)"
          width="8"
          x="12"
          y="1"></rect>
    <path d="m27,4H5c-2.2091,0-4,1.7908-4,4v16c0,2.2092,1.7909,4,4,4h22c2.2092,0,4-1.7908,4-4V8c0-2.2092-1.7908-4-4-4Zm3,20c0,1.6543-1.3457,3-3,3H5c-1.6543,0-3-1.3457-3-3V8c0-1.6543,1.3457-3,3-3h22c1.6543,0,3,1.3457,3,3v16Z"
          opacity=".15"
          stroke-width="0"></path>
    <path d="m27,5H5c-1.6569,0-3,1.3431-3,3v1c0-1.6569,1.3431-3,3-3h22c1.6569,0,3,1.3431,3,3v-1c0-1.6569-1.3431-3-3-3Z"
          fill="#fff"
          opacity=".2"
          stroke-width="0"></path>
    <path d="m14.6747,19.5135l-.5955-.4791-.5923.4599.2351-.709-.5953-.4791h.7153l.2507-.709.2277.709h.7227l-.573.4791.2047.7282Z"
          fill-rule="evenodd"
          fill="#fff"
          id="a"
          stroke-width="0"></path>
    <path d="m18.5072,19.5135l-.5955-.4791-.5923.4599.2351-.709-.5953-.4791h.7153l.2507-.709.2277.709h.7227l-.573.4791.2047.7282Z"
          fill-rule="evenodd"
          fill="#fff"
          id="a-2"
          stroke-width="0"></path>
    <path d="m14.6747,14.4029l-.5955-.4791-.5923.4599.2351-.709-.5953-.4791h.7153l.2507-.709.2277.709h.7227l-.573.4791.2047.7282Z"
          fill-rule="evenodd"
          fill="#fff"
          id="a-3"
          stroke-width="0"></path>
    <path d="m18.3541,14.4029l-.5955-.4791-.5923.4599.2351-.709-.5953-.4791h.7153l.2507-.709.2277.709h.7227l-.573.4791.2047.7282Z"
          fill-rule="evenodd"
          fill="#fff"
          id="a-4"
          stroke-width="0"></path>
    <path d="m11.4783,16.9583l-.5955-.4791-.5923.4599.2351-.709-.5953-.4791h.7153l.2507-.709.2277.709h.7227l-.573.4791.2047.7282Z"
          fill-rule="evenodd"
          fill="#fff"
          id="a-5"
          stroke-width="0"></path>
    <path d="m21.7014,16.9584l-.5955-.4791-.5923.4599.2351-.709-.5953-.4791h.7153l.2507-.709.2277.709h.7227l-.573.4791.2047.7282Z"
          fill-rule="evenodd"
          fill="#fff"
          id="a-6"
          stroke-width="0"></path>
</svg>
