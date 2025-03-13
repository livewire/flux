@php
$classes = Flux::classes()
    ->add('flex group/button')
    ->add([ // Make the first, middle, and last buttons have proper border radiuses...
        '[&>[data-flux-group-target]:not(:first-child):not(:last-child)]:rounded-none',
        '[&>[data-flux-group-target]:first-child:not(:last-child)]:rounded-e-none',
        '[&>[data-flux-group-target]:last-child:not(:first-child)]:rounded-s-none',

        '[&>*:not(:first-child):not(:last-child):not(:only-child)_[data-flux-group-target]]:rounded-none',
        '[&>*:first-child:not(:last-child)_[data-flux-group-target]]:rounded-e-none',
        '[&>*:last-child:not(:first-child)_[data-flux-group-target]]:rounded-s-none',
    ])
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-button-group>
    {{ $slot }}
</div>
