@blaze(fold: true)

@aware(['body' => 'seamless', 'size'])

@props([
    'body' => 'seamless',
    'size' => 'md',
])

@php
$classes = Flux::classes()
    ->add(match ($body) {
        'seamless', 'divided', 'separated' => '',
        'inset' => match ($size) {
            'xl' => 'rounded-xl',
            'lg' => 'rounded-lg',
            'md' => 'rounded-lg',
            'sm' => 'rounded-md',
        },
        'flush' => match ($size) {
            'xl' => 'rounded-2xl _[[data-flux-card-header]+&]:rounded-t-xl _[&:has(+[data-flux-card-footer])]:rounded-b-xl',
            'lg' => 'rounded-xl _[[data-flux-card-header]+&]:rounded-t-lg _[&:has(+[data-flux-card-footer])]:rounded-b-lg',
            'md' => 'rounded-xl _[[data-flux-card-header]+&]:rounded-t-lg _[&:has(+[data-flux-card-footer])]:rounded-b-lg',
            'sm' => 'rounded-lg _[[data-flux-card-header]+&]:rounded-t-lg _[&:has(+[data-flux-card-footer])]:rounded-b-lg',
        },
    })
    ->add(in_array($body, ['inset', 'flush']) ? match ($body) {
        'inset' => 'bg-white inset-ring inset-ring-zinc-300/75',
        'flush' => 'bg-white shadow-xs inset-ring inset-ring-zinc-300/75',
    } : '')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-body>
    {{ $slot }}
</div>
