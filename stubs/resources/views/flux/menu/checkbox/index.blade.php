@props([
    'variant' => 'default',
    'indent' => false,
    'suffix' => null,
    'label' => null,
    'icon' => null,
    'kbd' => null,
])

@php
if ($kbd) $suffix = $kbd;

$classes = Flux::classes()
    ->add('group/menu-checkbox flex items-center px-2 py-1.5 w-full focus:outline-none')
    ->add('rounded-md')
    ->add('text-left text-sm font-medium')
    ->add('[[disabled]_&]:opacity-50 [&[disabled]]:opacity-50')
    ->add([
        'text-zinc-800 data-[active]:bg-zinc-50 dark:text-white data-[active]:dark:bg-zinc-600',
        '[&_[data-flux-menu-item-icon]]:text-zinc-400 dark:[&_[data-flux-menu-item-icon]]:text-white/60 [&[data-active]_[data-flux-menu-item-icon]]:text-current',
    ])
    ;
@endphp

<ui-menu-checkbox {{ $attributes->class($classes) }} data-flux-menu-item-has-icon data-flux-menu-checkbox>
    <div class="w-7">
        <div class="hidden group-data-[checked]/menu-checkbox:block">
            <flux:icon variant="mini" icon="check" data-flux-menu-item-icon />
        </div>
    </div>

    {{ $label ?? $slot }}

    <?php if ($suffix): ?>
        <div class="ml-auto opacity-50 text-xs">
            {{ $suffix }}
        </div>
    <?php endif; ?>
</ui-menu-checkbox>
