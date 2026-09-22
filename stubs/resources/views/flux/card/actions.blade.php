@blaze(fold: true)

@php
// Placement (leading or trailing) and the hang into the header's padding live in flux.css...
$classes = Flux::classes()
    ->add('flex items-center gap-2')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-actions>
    {{ $slot }}
</div>
