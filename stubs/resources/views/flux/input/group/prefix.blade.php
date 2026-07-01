@blaze(fold: true)

@props([
    'size' => null,
])

@php
$classes = Flux::classes([
    'flex items-center px-4 whitespace-nowrap',
    'text-zinc-800 dark:text-zinc-200',
    'bg-zinc-800/5 dark:bg-white/20',
    'border-zinc-200 dark:border-white/10',
    'border-s border-t border-b shadow-xs',
])->add(match ($size) {
    default => 'text-base sm:text-sm rounded-s-lg',
    'sm' => 'text-sm rounded-s-md',
    'xs' => 'text-xs rounded-s-md',
});
@endphp

<div {{ $attributes->class($classes) }} data-flux-input-group-prefix>
    {{ $slot }}
</div>
