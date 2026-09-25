@blaze(fold: true)

@props([
    'size' => null,
])

@php
$classes = Flux::classes()
    // Tucks under whichever heading comes before it...
    ->add('[:where([data-flux-card-heading-size=base]+&)]:mt-1')
    ->add('[:where([data-flux-card-heading-size=lg]+&)]:mt-2')
    ;

$attributes = $attributes->merge(['class' => $classes]);
@endphp

<flux:text :$attributes :$size data-flux-card-subheading>
    {{ $slot }}
</flux:text>
