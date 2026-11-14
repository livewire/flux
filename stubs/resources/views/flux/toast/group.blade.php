@blaze(fold: true, safe: ['position'])

@props([
    'position' => 'bottom end',
    'expanded' => false,
    'transition' => null,
])

<ui-toast-group x-data x-on:toast-show.document="$el.showToast($event.detail)" popover="manual" position="{{ $position }}" {{ $expanded ? 'expanded' : '' }} {{ $transition === false ? 'data-flux-no-transition' : '' }} wire:ignore>
    {{ $slot }}
</ui-toast-group>
