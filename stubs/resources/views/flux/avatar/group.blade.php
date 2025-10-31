@blaze

@php
$classes = Flux::classes()
    ->add('flex isolate')
    ->add('*:not-first:-ml-2 **:ring-white **:dark:ring-zinc-900')
    ->add('**:data-[slot=avatar]:ring-4 **:data-[slot=avatar]:data-[size=sm]:ring-2 **:data-[slot=avatar]:data-[size=xs]:ring-2')
    ;
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
