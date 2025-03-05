@props([
    'src' => null,
    'size' => 'base',
])

@php
$classes = Flux::classes()
    ->add('overflow-hidden')
    ->add(match ($size) {
        'base' => 'size-10 rounded-sm',
        'sm' => 'size-8 rounded-sm',
        'xs' => 'size-6 rounded-sm',
    });
@endphp

<div {{ $attributes->class($classes) }} data-flux-avatar>
    <img src="{{ $src }}" alt="" />
</div>

