@blaze

@php
$classes = Flux::classes()
    ->add('z-20 fixed inset-0 bg-black/10 hidden')
    ->add('data-flux-sidebar-on-mobile:not-data-flux-sidebar-collapsed-mobile:block')
    ;
@endphp

<ui-sidebar-toggle {{ $attributes->class($classes) }} data-flux-sidebar-backdrop></ui-sidebar-toggle>
