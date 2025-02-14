@props([
    'iconVariant' => 'mini',
    'iconTrailing' => null,
    'variant' => 'default',
    'indent' => false,
    'suffix' => null,
    'label' => null,
    'kbd' => null,
])

@php
if ($kbd) $suffix = $kbd;

$iconClasses = Flux::classes()
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : null)
    ;

$iconTrailingClasses = Flux::classes()
    ->add('ml-auto')
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : null)
    ;

$classes = Flux::classes()
    ->add('group/menu-checkbox flex items-center px-2 py-1.5 w-full focus:outline-hidden')
    ->add('rounded-md')
    ->add('text-left text-sm font-medium')
    ->add('[[disabled]_&]:opacity-50 [&[disabled]]:opacity-50')
    ->add([
        'text-zinc-800 data-active:bg-zinc-50 dark:text-white dark:data-active:bg-zinc-600',
        '**:data-flux-menu-item-icon:text-zinc-400 dark:**:data-flux-menu-item-icon:text-white/60 [&[data-active]_[data-flux-menu-item-icon]]:text-current',
    ])
    ;
@endphp

<ui-menu-checkbox {{ $attributes->class($classes) }} data-flux-menu-item-has-icon data-flux-menu-checkbox>
    <div class="w-7">
        <div class="hidden group-data-checked/menu-checkbox:block">
            <flux:icon :variant="$iconVariant" icon="check" :class="$iconClasses" data-flux-menu-item-icon />
        </div>
    </div>

    {{ $label ?? $slot }}

    <?php if ($suffix): ?>
        <div class="ml-auto opacity-50 text-xs">
            {{ $suffix }}
        </div>
    <?php endif; ?>

    <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
        <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconTrailingClasses" data-flux-menu-item-icon />
    <?php elseif ($iconTrailing): ?>
        {{ $iconTrailing }}
    <?php endif; ?>
</ui-menu-checkbox>
