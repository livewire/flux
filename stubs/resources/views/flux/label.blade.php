@props([
    'badge' => null,
    'aside' => null,
])

@php
    $classes = Flux::classes()
        ->add('text-sm font-medium select-none')
        ->add('text-zinc-800 dark:text-white')
        ;
@endphp

<ui-label {{ $attributes->class($classes) }} data-flux-label>
    {{ $slot }}

    <?php if ($badge): ?>
        <span class="ml-1.5 text-zinc-800/70 text-xs bg-zinc-800/5 px-1.5 py-1 rounded-[4px] dark:bg-white/10 dark:text-zinc-300" aria-hidden="true">
            {{ $badge }}
        </span>
    <?php endif; ?>

    <?php if ($aside): ?>
        <span class="ml-1.5 text-zinc-800/70 text-xs bg-zinc-800/5 px-1.5 py-1 rounded-[4px] dark:bg-white/10 dark:text-zinc-300" aria-hidden="true">
            {{ $aside }}
        </span>
    <?php endif; ?>
</ui-label>
