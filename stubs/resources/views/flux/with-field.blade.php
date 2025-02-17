@php
extract(Flux::forwardedAttributes($attributes, [
    'name',
    'descriptionTrailing',
    'description',
    'label',
    'badge',
]));
@endphp

@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'descriptionTrailing' => null,
    'description' => null,
    'label' => null,
    'badge' => null,
])

<?php if ($label || $description): ?>
    <flux:field>
        <?php if ($label): ?>
            <flux:label :$badge>{{ $label }}</flux:label>
        <?php endif; ?>

        <?php if ($description): ?>
            <flux:description>{{ $description }}</flux:description>
        <?php endif; ?>

        {{ $slot }}

        <flux:error :$name />

        <?php if ($descriptionTrailing): ?>
            <flux:description>{{ $descriptionTrailing }}</flux:description>
        <?php endif; ?>
    </flux:field>
<?php else: ?>
    {{ $slot }}
<?php endif; ?>
