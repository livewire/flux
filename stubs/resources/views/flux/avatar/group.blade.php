@blaze(fold: true)

@php
$classes = Flux::classes()
    ->add('flex isolate')
    ->add('*:not-first:-ml-2 **:ring-white **:dark:ring-zinc-900')
    // Tooltips don't render a box, so the avatar inside one has to overlap instead...
    ->add('[&>[data-flux-tooltip]:not(:first-child)>:first-child]:-ml-2')
    ->add('**:data-[slot=avatar]:ring-4 **:data-[slot=avatar]:data-[size=sm]:ring-2 **:data-[slot=avatar]:data-[size=xs]:ring-2')
    ;
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
