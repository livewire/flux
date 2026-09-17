@blaze(fold: true, unsafe: [
    // flux:with-field props
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])


@props([
    'name' => null,
    'variant' => null,
    'size' => null,
])

@php
// We only want to show the name attribute on the checkbox if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    // A tooltip wrapper (via "tooltip" prop) becomes the flex item, so it has to stretch like the radio it wraps...
    ->add('[&>ui-tooltip]:flex-1')
    ->add('block flex p-1')
    ->add('rounded-lg bg-zinc-800/5 dark:bg-white/10')
    ->add($size === 'sm' ? 'h-8 py-[3px] px-[3px]' : 'h-10 p-1')
    ->add($size === 'sm' ? '-my-px h-[calc(2rem+2px)]' : '')
    ;
@endphp

<flux:with-field :$attributes>
    <ui-radio-group {{ $attributes->class($classes) }} @if($showName) name="{{ $name }}" @endif data-flux-radio-group-segmented>
        {{ $slot }}
    </ui-radio-group>
</flux:with-field>
