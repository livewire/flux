@php
$classes = Flux::classes()
    ->add('flex group/button')
    ->add([ // Make the first, middle, and last buttons have proper border radiuses...
        '[&>[data-flux-group-target]:not(:first-child):not(:last-child)]:rounded-none',
        '[&>[data-flux-group-target]:first-child:not(:last-child)]:rounded-r-none',
        '[&>[data-flux-group-target]:last-child:not(:first-child)]:rounded-l-none',

        '[&>*:not(:first-child):not(:last-child):not(:only-child)_[data-flux-group-target]]:rounded-none',
        '[&>*:first-child:not(:last-child)_[data-flux-group-target]]:rounded-r-none',
        '[&>*:last-child:not(:first-child)_[data-flux-group-target]]:rounded-l-none',
    ])
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-button-group>
    {{ $slot }}
</div>
