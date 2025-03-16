
@php
$classes = Flux::classes()
    ->add('flex isolate')
    ->add('*:not-first:-ml-2 *:ring-4 *:[:where(&)]:ring-white *:dark:ring-zinc-900')
    ;
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>