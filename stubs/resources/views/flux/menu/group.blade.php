@pure

@props([
    'heading' => null,
])

@php
$classes = Flux::classes()
    ->add('-mx-[.3125rem] px-[.3125rem]')
    ->add('[&+&>[data-flux-menu-separator-top]]:hidden [&:first-child>[data-flux-menu-separator-top]]:hidden [&:last-child>[data-flux-menu-separator-bottom]]:hidden')
    ;
@endphp

<div {{ $attributes->class($classes) }} role="group" data-flux-menu-group>
    <flux:menu.separator data-flux-menu-separator-top />

    <?php if ($heading): ?>
        <flux:menu.heading>{{ $heading }}</flux:menu.heading>
    <?php endif; ?>

    {{ $slot }}

    <flux:menu.separator data-flux-menu-separator-bottom />
</div>
