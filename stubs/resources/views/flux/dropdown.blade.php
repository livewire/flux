@blaze(fold: true, safe: ['position', 'align'])

@props([
    'position' => 'bottom',
    'align' => 'start',
    'transition' => null,
])

@php
if ($transition === false) {
    $attributes = $attributes->merge(['data-flux-no-transition' => '']);
}

// Support adding the .self modifier to the wire:model directive...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);

    $wireModel->directive .= '.self';

    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}
@endphp

<ui-dropdown position="{{ $position }} {{ $align }}" {{ $attributes }} data-flux-dropdown>
    {{ $slot }}
</ui-dropdown>
