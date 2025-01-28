@props([
    'iconVariant' => 'mini',
    'iconTrailing' => null,
    'heading' => '',
    'icon' => null,
])

@php
$iconClasses = Flux::classes()
    ->add('ml-auto text-zinc-400 [[data-flux-menu-item]:hover_&]:text-current')
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : '');
@endphp

<ui-submenu data-flux-menu-submenu>
    <flux:menu.item :$icon :$iconVariant>
        {{ $heading }}

        <x-slot:suffix>
            <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
                <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconClasses" />
            <?php elseif ($iconTrailing): ?>
                {{ $iconTrailing }}
            <?php else: ?>
                <flux:icon icon="chevron-right" :variant="$iconVariant" :class="$iconClasses" />
            <?php endif; ?>
        </x-slot:suffix>
    </flux:menu.item>

    <flux:menu>
        {{ $slot }}
    </flux:menu>
</ui-submenu>
