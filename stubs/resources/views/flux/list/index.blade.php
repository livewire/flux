@blaze(fold: true)

@props([
    'variant' => null,
])

@php
$classes = Flux::classes()
    ->add($variant !== 'bare' ? [
        'overflow-hidden rounded-xl',
        'bg-white dark:bg-white/10',
        'border border-zinc-200 dark:border-white/10',
        'divide-y divide-zinc-200 dark:divide-white/10',
    ] : null)
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-list>
    {{ $slot }}
</div>
