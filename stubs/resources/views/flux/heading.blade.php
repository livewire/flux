@props([
    'size' => 'base',
    'accent' => false,
    'level' => null,
])

@php
$classes = Flux::classes()
    ->add('font-medium')
    ->add(match ($accent) {
        true => 'text-[var(--color-accent-content)]',
        default => 'text-zinc-800 dark:text-white',
    })
    ->add(match ($size) {
        'xl' => 'text-2xl [&:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&]:mt-2',
        'lg' => 'text-base [&:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&]:mt-2',
        'base' => 'text-sm [&:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&]:mt-2',
    })
    ;
@endphp

<?php switch ((int) $level): case(1): ?>
        <h1 {{ $attributes->class($classes) }} data-flux-heading>{{ $slot }}</h1>

        @break
    <?php case(2): ?>
        <h2 {{ $attributes->class($classes) }} data-flux-heading>{{ $slot }}</h2>

        @break
    <?php case(3): ?>
        <h3 {{ $attributes->class($classes) }} data-flux-heading>{{ $slot }}</h3>

        @break
    <?php case(4): ?>
        <h4 {{ $attributes->class($classes) }} data-flux-heading>{{ $slot }}</h4>

        @break
    <?php default: ?>
        <div {{ $attributes->class($classes) }} data-flux-heading>{{ $slot }}</div>
<?php endswitch; ?>
