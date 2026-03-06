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
    <rect x="10" y="4" width="12" height="24" fill="#0868a9" stroke-width="0"></rect>
    <path d="m5,4h6v24h-6c-2.2077,0-4-1.7923-4-4V8c0-2.2077,1.7923-4,4-4Z" fill="#fff" stroke-width="0"></path>
    <path d="m25,4h6v24h-6c-2.2077,0-4-1.7923-4-4V8c0-2.2077,1.7923-4,4-4Z" transform="translate(52 32) rotate(180)" fill="#ffcc01" stroke-width="0"></path>
    <path d="m27,4H5c-2.2091,0-4,1.7908-4,4v16c0,2.2092,1.7909,4,4,4h22c2.2092,0,4-1.7908,4-4V8c0-2.2092-1.7908-4-4-4Zm3,20c0,1.6543-1.3457,3-3,3H5c-1.6543,0-3-1.3457-3-3V8c0-1.6543,1.3457-3,3-3h22c1.6543,0,3,1.3457,3,3v16Z" opacity=".15" stroke-width="0"></path>
    <path d="m27,5H5c-1.6569,0-3,1.3431-3,3v1c0-1.6569,1.3431-3,3-3h22c1.6569,0,3,1.3431,3,3v-1c0-1.6569-1.3431-3-3-3Z" fill="#fff" opacity=".2" stroke-width="0"></path>
</svg>
