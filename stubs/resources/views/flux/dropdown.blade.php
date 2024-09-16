@props([
    'position' => 'bottom start',
])

<ui-dropdown position="{{ $position }}" {{ $attributes }} data-flux-dropdown>
    {{ $slot }}
</ui-dropdown>
