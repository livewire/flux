
@php
$classes = Flux::classes()
    ->add('flex')
    ->add('*:-ml-4 *:ring-3 *:ring-white *:dark:ring-zinc-800')
    ;
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>