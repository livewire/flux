@props([
    'iconVariant' => 'mini',
    'icon' => null,
])

@php
    $classes = Flux::classes()
        ->add('flex items-center gap-2 text-sm font-medium')
        ;

    $iconClasses = Flux::classes()
        ->add('inline-block size-5 text-zinc-500 dark:text-zinc-400')
        ->add($attributes->pluck('class:icon'))
        ;
@endphp

<div {{ $attributes->class($classes) }} data-slot="heading">
    <?php if (is_string($icon) && $icon !== ''): ?>
        <flux:icon :icon="$icon" :variant="$iconVariant" :class="$iconClasses" />
    <?php elseif ($icon): ?>
        {{ $icon }}
    <?php endif; ?>

    {{ $slot }}
</div>
