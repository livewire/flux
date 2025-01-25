@props([
    'interactive' => null,
    'position' => 'top',
    'align' => 'center',
    'content' => null,
    'kbd' => null,
    'toggleable' => null,
])

@php
// Support adding the .self modifier to the wire:model directive...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);

    $wireModel->directive .= '.self';

    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}
@endphp

<?php if ($toggleable): ?>
    <ui-dropdown position="{{ $position }} {{ $align }}" {{ $attributes }} data-flux-tooltip>
        {{ $slot }}

        <?php if ($content !== null): ?>
            <flux:tooltip.content :$kbd>{{ $content }}</flux:tooltip.content>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="{{ $position }} {{ $align }}" {{ $attributes }} data-flux-tooltip @if ($interactive) interactive @endif>
        {{ $slot }}

        <?php if ($content !== null): ?>
            <flux:tooltip.content :$kbd>{{ $content }}</flux:tooltip.content>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
