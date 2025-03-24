@php
$classes = Flux::classes([
    'flex items-center px-4 text-sm whitespace-nowrap',
    'text-zinc-800 dark:text-zinc-200',
    'bg-zinc-800/5 dark:bg-white/20',
    'border-zinc-200 dark:border-white/10',
    'rounded-e-lg',
    'border-e border-t border-b shadow-xs',
]);
@endphp

<div {{ $attributes->class($classes) }} data-flux-input-group-suffix>
    {{ $slot }}
</div>
