@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'variant' => null,
])

@php
$classes = Flux::classes()
    // Adjust spacing between fields...
    ->add('*:data-flux-field:mb-3')
    ->add('[&>[data-flux-field]:has(>[data-flux-description])]:mb-4')
    ->add('[&>[data-flux-field]:last-child]:mb-0!')
    ;
@endphp

<flux:with-field :$attributes>
    <ui-radio-group {{ $attributes->class($classes) }} data-flux-radio-group>
        {{ $slot }}
    </ui-radio-group>
</flux:with-field>
