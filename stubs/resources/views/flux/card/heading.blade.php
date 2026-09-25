@blaze(fold: true)

@props([
    'size' => 'base',
    'accent' => false,
    'level' => null,
])

@php
$classes = Flux::classes()
    // Shared with flux.css, which hangs actions by how much taller they are than this line...
    ->add('leading-[var(--flux-card-leading)]')
    ;

$attributes = $attributes->merge([
    'class' => $classes,
    'data-flux-card-heading' => '',
    'data-flux-card-heading-size' => $size,
]);
@endphp

<flux:heading :$attributes :$size :$accent :$level>
    {{ $slot }}
</flux:heading>
