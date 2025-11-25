@blaze

@aware(['animate' => null])

@props([
    'animate' => null,
])

@php
    $classes = Flux::classes()
        ->add('[:where(&)]:h-4 [:where(&)]:rounded-md [:where(&)]:bg-zinc-400/20')
        ->add(match ($animate) {
            'shimmer' => [
                'relative before:absolute before:inset-0 before:-translate-x-full',
                'overflow-hidden isolate',
                '[:where(&)]:[--flux-shimmer-color:white]',
                'dark:[:where(&)]:[--flux-shimmer-color:var(--color-zinc-900)]',
                'before:z-10 before:animate-[flux-shimmer_2s_infinite]',
                'before:bg-gradient-to-r before:from-transparent before:via-[var(--flux-shimmer-color)]/50 dark:before:via-[var(--flux-shimmer-color)]/50 before:to-transparent',
            ],
            'pulse' => 'animate-pulse',
            default => '',
        })
        ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-skeleton>
    {{ $slot }}
</div>