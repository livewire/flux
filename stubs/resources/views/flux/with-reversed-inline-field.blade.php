@blaze(fold: true, unsafe: [
    // flux:with-inline-field props
    'name', 'label', 'description',
])

@php
extract(Flux::forwardedattributes($attributes, [
    'name',
    'description',
    'label',
]));
@endphp

@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'description' => null,
    'label' => null,
])

<?php if ($label || $description): ?>
    <flux:field variant="inline">
        <?php if ($label): ?>
            <flux:label>{{ $label }}</flux:label>
        <?php endif; ?>

        <?php if ($description): ?>
            <flux:description>{{ $description }}</flux:description>
        <?php endif; ?>

        {{ $slot }}

        @unblaze(scope: ['name' => $name])
        <flux:error :name="$scope['name']" />
        @endunblaze
    </flux:field>
<?php else: ?>
    {{ $slot }}
<?php endif; ?>

