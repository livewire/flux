@props([
    'position' => 'bottom',
    'align' => 'start',
])

<ui-dropdown position="{{ $position }} {{ $align }}" {{ $attributes }} data-flux-dropdown>
    {{ $slot }}
</ui-dropdown>
