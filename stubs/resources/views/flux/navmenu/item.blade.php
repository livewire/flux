@props([
    'variant' => 'default',
    'disabled' => false,
    'indent' => false,
    'suffix' => null,
    'value' => null,
    'icon' => null,
    'kbd' => null,
])

@php
if ($kbd) $suffix = $kbd;

$classes = Flux::classes()
    ->add('group flex items-center px-2 py-2 lg:py-1.5 w-full')
    ->add('rounded-md')
    ->add('text-left text-sm font-medium')
    ->add(match ($variant) {
        'danger' => [
            'text-zinc-800 hover:text-red-600 hover:bg-red-50 dark:text-white dark:hover:bg-red-400/20 dark:hover:text-red-400',
            '[&_[data-navmenu-icon]]:text-zinc-400 dark:[&_[data-navmenu-icon]]:text-white/60 [&:hover_[data-navmenu-icon]]:text-current',
        ],
        'default' => [
            'text-zinc-800 hover:bg-zinc-50 dark:text-white hover:dark:bg-zinc-600',
            '[&_[data-navmenu-icon]]:text-zinc-400 dark:[&_[data-navmenu-icon]]:text-white/60 [&:hover_[data-navmenu-icon]]:text-current',
        ]
    })
    ->add($disabled ? 'text-zinc-400' : '')
    ;
@endphp

<flux:button-or-link :attributes="$attributes->class($classes)" data-flux-navmenu-item>
    <?php if ($indent): ?>
        <div class="w-7"></div>
    <?php endif; ?>

    <?php if ($icon): ?>
        <flux:icon :$icon variant="mini" class="mr-2" data-navmenu-icon />
    <?php endif; ?>

    {{ $slot }}

    <?php if ($suffix): ?>
        <?php if (is_string($suffix)): ?>
            <div class="ml-auto opacity-50 text-xs">
                {{ $suffix }}
            </div>
        <?php else: ?>
            {{ $suffix }}
        <?php endif; ?>
    <?php endif; ?>
</flux:button-or-link>
