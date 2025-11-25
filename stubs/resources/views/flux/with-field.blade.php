@php
extract(Flux::forwardedAttributes($attributes, [
    'name',
    'descriptionTrailing',
    'description',
    'label',
    'badge',
]));
@endphp

@php $descriptionTrailing = $descriptionTrailing ??= $attributes->pluck('description:trailing'); @endphp

@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'descriptionTrailing' => null,
    'description' => null,
    'label' => null,
    'badge' => null,
])

<?php if (isset($label) || isset($description)): ?>
    <?php

        $fieldAttributes = Flux::attributesAfter('field:', $attributes, []);
        $labelAttributes = Flux::attributesAfter('label:', $attributes, ['badge' => $badge]);
        $descriptionAttributes = Flux::attributesAfter('description:', $attributes, []);
        $errorAttributes = Flux::attributesAfter('error:', $attributes, ['name' => $name]);
    ?>
    <flux:field :attributes="$fieldAttributes">
        <?php if (isset($label)): ?>
            <flux:label :attributes="$labelAttributes">{{ $label }}</flux:label>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <flux:description :attributes="$descriptionAttributes">{{ $description }}</flux:description>
        <?php endif; ?>

        {{ $slot }}

        <flux:error :attributes="$errorAttributes" />

        <?php if (isset($descriptionTrailing)): ?>
            <flux:description :attributes="$descriptionAttributes">{{ $descriptionTrailing }}</flux:description>
        <?php endif; ?>
    </flux:field>
<?php else: ?>
    {{ $slot }}
<?php endif; ?>
