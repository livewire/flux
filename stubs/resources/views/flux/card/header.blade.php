@blaze(fold: true)

@aware(['body' => null, 'variant' => null, 'divider' => null])

@props([
    'body' => null,
    'variant' => null,
    'divider' => null,
    'size' => null,
])

@php
// Divided and separated cards are white, so this is where the card's variant shows its color. The bands recede
// from the body in both modes, so in dark mode they darken it rather than lighten it...
$tint = match ($variant) {
    'muted' => 'bg-zinc-900/4 dark:bg-black/20',
    'soft' => 'bg-zinc-900/3 dark:bg-black/15',
    default => null,
};

// Divided cards draw their lines across the card. divider="inset" stops them at the content's edges instead,
// which takes a drawn line rather than a border. The border stays, invisibly, so both take the same room...
$line = match ($divider) {
    'inset' => 'border-b border-transparent relative after:absolute after:inset-x-[var(--flux-card-part-px)] after:-bottom-px after:border-b after:border-zinc-900/5 dark:after:border-white/10',
    default => 'border-b border-zinc-900/5 dark:border-white/10',
};

// Layout, padding, and how <flux:card.actions> hang into it all live in flux.css...
$classes = Flux::classes()
    ->add(match ($body) {
        'divided' => [$line, $tint],
        'separated' => $tint ?? 'bg-zinc-900/3 dark:bg-black/15',
        default => '',
    })
    ;

// Only a card above sets body. Without one this part is on its own, so it carries its own size for flux.css...
if ($body === null) {
    $attributes = $attributes->merge([
        'data-flux-card-standalone' => true,
        'data-flux-card-size' => $size,
    ]);
}
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-header>
    {{ $slot }}
</div>
