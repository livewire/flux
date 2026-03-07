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
    <path d="m30.8588,7c-.4461-1.7222-1.9969-3-3.8586-3h-12.0002v3h15.8588Z"
          fill="#fff"
          stroke-width="0"></path>
    <rect fill="#001b69"
          height="3"
          stroke-width="0"
          width="16"
          x="15"
          y="10"></rect>
    <path d="m31,7.9982c-.0002-.3468-.0581-.6774-.1412-.9982h-15.8588v3h16v-2.0018Z"
          fill="#ca0a2b"
          stroke-width="0"></path>
    <rect fill="#fff"
          height="3"
          stroke-width="0"
          width="16"
          x="15"
          y="13"></rect>
    <rect fill="#ca0a2b"
          height="3"
          stroke-width="0"
          width="30"
          x="1"
          y="16"></rect>
    <path d="m1.0002,24c0,.3474.0582.6786.1414,1h29.7172c.0831-.3208.1411-.6514.1412-.9982v-2.0018H1.0002v2Z"
          fill="#fff"
          stroke-width="0"></path>
    <rect fill="#001b69"
          height="3"
          stroke-width="0"
          width="30"
          x="1"
          y="19"></rect>
    <path d="m30.8588,25H1.1416c.4461,1.7222,1.9969,3,3.8586,3h22c1.8617,0,3.4125-1.2778,3.8586-3Z"
          fill="#ca0a2b"
          stroke-width="0"></path>
    <path d="m5,4h11v12H1v-8c0-2.2077,1.7923-4,4-4Z"
          fill="#001b69"
          stroke-width="0"></path>
    <path d="m6.5002,13.7737v2.2263h4v-2.2272l3.0371,2.2272h2.4629v-1.2411l-3.7619-2.7589h3.7619v-4h-2.74l2.74-2.0093v-1.9907h-1.441l-4.059,2.9769v-2.9769h-4v2.7935l-3.2566-2.3892c-.7675.3741-1.3895.9834-1.7856,1.7379l2.5321,1.8578H1.0002s0,0,0,0v4h3.7632l-3.7632,2.7599v1.2401h2.4642l3.0358-2.2263Z"
          fill="#fff"
          stroke-width="0"></path>
    <path d="m1.8057,5.5891l3.2854,2.4109h1.3636l-4.0952-3.0047c-.2043.1795-.3897.3765-.5539.5938Z"
          fill="#ca0a2b"
          stroke-width="0"></path>
    <polygon fill="#ca0a2b"
             points=".9998 16 6.4544 12 6.4544 13 2.3635 16 .9998 16"
             stroke-width="0"></polygon>
    <polygon fill="#ca0a2b"
             points="9.5002 16 7.5002 16 7.5002 11 1.0002 11 1.0002 9 7.5002 9 7.5002 4 9.5002 4 9.5002 9 16.0002 9 16.0002 11 9.5002 11 9.5002 16"
             stroke-width="0"></polygon>
    <polygon fill="#ca0a2b"
             points="16.0002 15.6667 11.0002 12 11.0002 13 15.0911 16 16.0002 16 16.0002 15.6667"
             stroke-width="0"></polygon>
    <polygon fill="#ca0a2b"
             points="16.0002 4 15.7518 4 10.2913 8.0044 11.6549 8.0044 16.0002 4.8179 16.0002 4"
             stroke-width="0"></polygon>
    <path d="m27.0002,4H5.0002c-2.2091,0-4,1.7908-4,4v16c0,2.2092,1.7909,4,4,4h22c2.2092,0,4-1.7908,4-4V8c0-2.2092-1.7908-4-4-4Zm3,20c0,1.6543-1.3457,3-3,3H5.0002c-1.6543,0-3-1.3457-3-3V8c0-1.6543,1.3457-3,3-3h22c1.6543,0,3,1.3457,3,3v16Z"
          opacity=".15"
          stroke-width="0"></path>
    <path d="m27,5H5c-1.6569,0-3,1.3431-3,3v1c0-1.6569,1.3431-3,3-3h22c1.6569,0,3,1.3431,3,3v-1c0-1.6569-1.3431-3-3-3Z"
          fill="#fff"
          opacity=".2"
          stroke-width="0"></path>
</svg>
