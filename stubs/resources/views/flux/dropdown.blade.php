@props([
    'position' => 'bottom',
    'align' => 'start',
])

@php
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
