@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'variant' => null,
    'size' => null,
])

@php
$classes = Flux::classes()
    ->add('block flex p-1')
    ->add('rounded-lg bg-zinc-800/5 dark:bg-white/10')
    ->add($size === 'sm' ? 'h-8 py-[3px] px-[3px]' : 'h-10 p-1')
    ->add($size === 'sm' ? '-my-px h-[calc(2rem+2px)]' : '')
    ;
@endphp

<flux:with-field :$attributes>
    <ui-radio-group {{ $attributes->class($classes) }} data-flux-radio-group-segmented>
        {{ $slot }}
    </ui-radio-group>
</flux:with-field>
