@blaze(fold: true)

@aware(['body' => 'seamless', 'variant' => null])

@props([
    'body' => 'seamless',
    'variant' => null,
])

@php
// Divided and separated cards are white, so this is where the card's variant shows its color...
$tint = match ($variant) {
    'muted' => 'bg-zinc-900/4',
    'soft' => 'bg-zinc-900/3',
    default => null,
};

// Layout, padding, and how <flux:card.actions> hang into it all live in flux.css...
$classes = Flux::classes()
    ->add(match ($body) {
        'divided' => ['border-b border-zinc-900/5', $tint],
        'separated' => $tint ?? 'bg-zinc-900/3',
        default => '',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-header>
    {{ $slot }}
</div>
