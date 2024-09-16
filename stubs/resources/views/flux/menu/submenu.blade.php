@props([
    'heading' => '',
])

<ui-submenu data-flux-menu-submenu>
    <flux:menu.item>
        {{ $heading }}

        <x-slot:suffix>
            <flux:icon class="ml-auto text-zinc-400 [[data-flux-menu-item]:hover_&]:text-current" icon="chevron-right" variant="mini" />
        </x-slot:suffix>
    </flux:menu.item>

    <flux:menu>
        {{ $slot }}
    </flux:menu>
</ui-submenu>
