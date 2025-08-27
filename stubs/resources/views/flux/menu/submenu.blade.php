@pure

@php $iconTrailing ??= $attributes->pluck('icon:trailing'); @endphp
@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'iconVariant' => 'mini',
    'iconTrailing' => null,
    'heading' => '',
    'icon' => null,
    'keepOpen' => false,
])

@php
$iconClasses = Flux::classes()
    ->add('ms-auto text-zinc-400 [[data-flux-menu-item]:hover_&]:text-current')
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
                <flux:icon icon="chevron-right" :variant="$iconVariant" :class="$iconClasses->add('rtl:hidden')" />
                <flux:icon icon="chevron-left" :variant="$iconVariant" :class="$iconClasses->add('hidden rtl:inline')" />
            <?php endif; ?>
        </x-slot:suffix>
    </flux:menu.item>

    <flux:menu :keep-open="$keepOpen">
        {{ $slot }}
    </flux:menu>
</ui-submenu>
