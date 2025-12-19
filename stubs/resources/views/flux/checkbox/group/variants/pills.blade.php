@props([
    'variant' => null,
    'size' => null,
    'name' => null,
])

@php
// We only want to show the name attribute on the checkbox if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    ->add('flex flex-wrap gap-3')
    ;
@endphp

<flux:with-field :$attributes>
    <ui-checkbox-group {{ $attributes->class($classes) }} @if($showName) name="{{ $name }}" @endif data-flux-checkbox-group-pills>
        {{ $slot }}
    </ui-checkbox-group>
</flux:with-field>
