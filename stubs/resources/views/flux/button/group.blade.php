@php
$classes = Flux::classes()
    ->add('flex group/button')
    // Make the first, middle, and last buttons have proper border radiuses...
    ->add([
        '[&>*:not(:last-child):not(:first-child)]:rounded-none',
        'first:*:rounded-r-none',
        'last:*:rounded-l-none',
    ])
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-button-group>
    {{ $slot }}
</div>
