@blaze(fold: true)

@props([
    'size' => null,
])

@php
$classes = Flux::classes()
    // Tucks under whichever heading comes before it...
    ->add('[:where([data-flux-heading]+&)]:mt-1')
    ;

$attributes = $attributes->merge(['class' => $classes]);
@endphp

<flux:text :$attributes :$size data-flux-card-subheading>
    {{ $slot }}
</flux:text>
