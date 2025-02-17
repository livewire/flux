@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
])

@php
$classes = Flux::classes()
    ->add('w-full flex')
    ->add('*:data-flux-input:grow')
    ->add([
        '[&>[data-flux-input]:not(:first-child):not(:last-child)>[data-flux-group-target]:not([data-invalid])]:border-x-0',
        '[&>[data-flux-input]:first-child:not(:last-child)>[data-flux-group-target]:not([data-invalid])]:border-r-0',
        '[&>[data-flux-input]:last-child:not(:first-child)>[data-flux-group-target]:not([data-invalid])]:border-l-0',

        // Prevent sandwhiched selects (next to inputs) from causing double borders...
        '[&>*:not(:first-child):not(:last-child):not(:only-child)_[data-flux-group-target]:not([data-invalid])]:border-l-0',

        // "Weld" the borders of inputs together by overriding their border radiuses...
        '[&>[data-flux-group-target]:not(:first-child):not(:last-child)]:rounded-none',
        '[&>[data-flux-group-target]:first-child:not(:last-child)]:rounded-r-none',
        '[&>[data-flux-group-target]:last-child:not(:first-child)]:rounded-l-none',

        // "Weld" borders for sub-children of group targets (button element inside ui-select element, etc.)...
        '[&>*:not(:first-child):not(:last-child):not(:only-child)>[data-flux-group-target]]:rounded-none',
        '[&>*:first-child:not(:last-child)>[data-flux-group-target]]:rounded-r-none',
        '[&>*:last-child:not(:first-child)>[data-flux-group-target]]:rounded-l-none',

        // "Weld" borders for sub-sub-children of group targets (input element inside div inside ui-select element (combobox))...
        '[&>*:not(:first-child):not(:last-child):not(:only-child)>[data-flux-input]>[data-flux-group-target]]:rounded-none',
        '[&>*:first-child:not(:last-child)>[data-flux-input]>[data-flux-group-target]]:rounded-r-none',
        '[&>*:last-child:not(:first-child)>[data-flux-input]>[data-flux-group-target]]:rounded-l-none',
    ])
    ;
@endphp

<flux:with-field :$attributes :$name>
    <div {{ $attributes->class($classes) }} data-flux-input-group>
        {{ $slot }}
    </div>
</flux:with-field>
