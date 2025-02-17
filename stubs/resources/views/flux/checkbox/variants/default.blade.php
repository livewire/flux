@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
])

@php
$classes = Flux::classes()
    ->add('flex size-[1.125rem] rounded-[.3rem] mt-px outline-offset-2')
    ;
@endphp

<flux:with-inline-field :$attributes>
    <ui-checkbox {{ $attributes->class($classes) }} data-flux-control data-flux-checkbox>
        <flux:checkbox.indicator />
    </ui-checkbox>
</flux:with-inline-field>
