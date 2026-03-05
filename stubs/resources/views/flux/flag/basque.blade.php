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
    <rect x="1" y="4" width="30" height="24" rx="4" ry="4" fill="#d62818" stroke-width="0"></rect>
    <path d="m27.7097,4.0715l-11.7097,9.3677L4.2903,4.0715c-1.4476.2603-2.6104,1.2986-3.0678,2.6672l11.5765,9.2612L1.2225,25.2612c.4575,1.3687,1.6202,2.407,3.0678,2.6672l11.7097-9.3677,11.7097,9.3677c1.4476-.2603,2.6104-1.2986,3.0678-2.6672l-11.5765-9.2612,11.5765-9.2612c-.4575-1.3687-1.6202-2.407-3.0678-2.6672Z" fill="#019c46" stroke-width="0"></path>
    <rect x="14" y="4" width="4" height="24" fill="#fff" stroke-width="0"></rect>
    <rect x="14" y="1" width="4" height="30" transform="translate(32) rotate(90)" fill="#fff" stroke-width="0"></rect>
    <path d="m27,4H5c-2.2091,0-4,1.7908-4,4v16c0,2.2092,1.7909,4,4,4h22c2.2092,0,4-1.7908,4-4V8c0-2.2092-1.7908-4-4-4Zm3,20c0,1.6543-1.3457,3-3,3H5c-1.6543,0-3-1.3457-3-3V8c0-1.6543,1.3457-3,3-3h22c1.6543,0,3,1.3457,3,3v16Z" opacity=".15" stroke-width="0"></path>
    <path d="m27,5H5c-1.6569,0-3,1.3431-3,3v1c0-1.6569,1.3431-3,3-3h22c1.6569,0,3,1.3431,3,3v-1c0-1.6569-1.3431-3-3-3Z" fill="#fff" opacity=".2" stroke-width="0"></path>
</svg>