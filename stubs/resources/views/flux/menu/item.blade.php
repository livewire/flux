@props([
    'variant' => 'default',
    'suffix' => null,
    'value' => null,
    'icon' => null,
    'kbd' => null,
])

@php
if ($kbd) $suffix = $kbd;

$classes = Flux::classes()
    ->add('flex items-center px-2 py-1.5 w-full focus:outline-none')
    ->add('rounded-md')
    ->add('text-left text-sm font-medium')
    ->add('[&[disabled]]:opacity-50')
    ->add(match ($variant) {
        'danger' => [
            'text-zinc-800 data-[active]:text-red-600 data-[active]:bg-red-50 dark:text-white dark:data-[active]:bg-red-400/20 dark:data-[active]:text-red-400',
            '[&_[data-flux-menu-item-icon]]:text-zinc-400 dark:[&_[data-flux-menu-item-icon]]:text-white/60 [&[data-active]_[data-flux-menu-item-icon]]:text-current',
        ],
        'default' => [
            'text-zinc-800 data-[active]:bg-zinc-50 dark:text-white data-[active]:dark:bg-zinc-600',
            '[&_[data-flux-menu-item-icon]]:text-zinc-400 dark:[&_[data-flux-menu-item-icon]]:text-white/60 [&[data-active]_[data-flux-menu-item-icon]]:text-current',
        ]
    })
    ;

$suffixClasses = Flux::classes()
    ->add('ml-auto text-xs text-zinc-400')
    ;
@endphp

<flux:button-or-link :attributes="$attributes->class($classes)" data-flux-menu-item :data-flux-menu-item-has-icon="!! $icon">
    <?php if ($icon): ?>
        <flux:icon :$icon variant="mini" class="mr-2" data-flux-menu-item-icon />
    <?php else: ?>
        <div class="w-7 hidden [[data-flux-menu]:has(>[data-flux-menu-item-has-icon])_&]:block"></div>
    <?php endif; ?>

    {{ $slot }}

    <?php if ($suffix): ?>
        <?php if (is_string($suffix)): ?>
            <div class="{{ $suffixClasses }}">
                {{ $suffix }}
            </div>
        <?php else: ?>
            {{ $suffix }}
        <?php endif; ?>
    <?php endif; ?>

    {{ $submenu ?? '' }}
</flux:button-or-link>
