@pure

@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'iconVariant' => 'mini',
    'icon' => null,
])

@php
    $classes = Flux::classes()
        ->add('flex items-center gap-2 text-sm font-medium')
        ;

    $iconClasses = Flux::classes()
        ->add('inline-block size-5 text-[var(--callout-icon)] dark:text-[var(--callout-icon)]')
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
