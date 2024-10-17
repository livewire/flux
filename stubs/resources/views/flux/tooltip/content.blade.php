@props([
    'kbd' => null,
])

@php
$classes = Flux::classes([
    'relative py-2 px-2.5',
    'rounded-md',
    'text-xs text-white font-medium',
    'bg-zinc-800 dark:bg-zinc-700 dark:border dark:border-white/10',
    'p-0 overflow-visible',
]);
@endphp

<div popover="manual" {{ $attributes->class($classes) }} data-flux-tooltip-content>
    {{ $slot }}

    <?php if ($kbd): ?>
        <span class="pl-1 text-zinc-300">{{ $kbd }}</span>
    <?php endif; ?>
</div>
