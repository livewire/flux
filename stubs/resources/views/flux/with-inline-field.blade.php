@blaze(fold: true, unsafe: [
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

<?php if (isset($label) || isset($description)): ?>
    <flux:field variant="inline">
        {{ $slot }}

        <?php if (isset($label)): ?>
            <flux:label>{{ $label }}</flux:label>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <flux:description>{{ $description }}</flux:description>
        <?php endif; ?>

        @unblaze(scope: ['name' => $name])
        <flux:error :name="$scope['name']" />
        @endunblaze
    </flux:field>
<?php else: ?>
    {{ $slot }}
<?php endif; ?>

