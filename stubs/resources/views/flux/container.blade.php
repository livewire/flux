@blaze

@php
$classes = Flux::classes()
    ->add('mx-auto w-full [:where(&)]:max-w-7xl px-6 lg:px-8')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-container>
    {{ $slot }}
</div>
