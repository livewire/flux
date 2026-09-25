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
// from the body in both modes, so in dark mode they darken it rather than lighten it. Every band class carries
// flux-band:, so a header or footer placed inside a body stays bare (see flux.css)...
$tint = match ($variant) {
    'muted' => 'flux-band:bg-zinc-900/4 flux-band:dark:bg-black/20',
    'soft' => 'flux-band:bg-zinc-900/3 flux-band:dark:bg-black/35',
    default => null,
};

// Divided cards draw their lines across the card. divider="inset" stops them at the content's edges instead,
// which takes a drawn line rather than a border. The border stays, invisibly, so both take the same room. A line
// only divides, so there's none with nothing below it (a card that's only a header, say)...
$line = match ($divider) {
    'inset' => 'flux-band:not-last:border-b flux-band:not-last:border-transparent flux-band:not-last:relative flux-band:not-last:after:absolute flux-band:not-last:after:inset-x-[var(--flux-card-part-px)] flux-band:not-last:after:-bottom-px flux-band:not-last:after:border-b flux-band:not-last:after:border-zinc-900/5 flux-band:not-last:dark:after:border-white/10',
    default => 'flux-band:not-last:border-b flux-band:not-last:border-zinc-900/5 flux-band:not-last:dark:border-white/10',
};

// A filled card has no edge, just its fill running under a transparent border. Its bands sit inside that
// border, so a separated one paints its tint out over it too with a ring (clipped off the body's side), or a
// rim of the card's own fill would show around it. The ring has to match the band exactly, so the two colors
// are written side by side...
$filledBand = 'flux-band:bg-zinc-900/2 flux-band:ring-zinc-900/2 flux-band:dark:bg-black/15 flux-band:dark:ring-black/15 flux-band:ring flux-band:[clip-path:inset(-1px_-1px_0_-1px)]';

// Layout, padding, and how <flux:card.actions> hang into it all live in flux.css...
$classes = Flux::classes()
    ->add(match ($body) {
        'divided' => [$line, $tint],
        'separated' => $variant === 'filled' ? $filledBand : ($tint ?? 'flux-band:bg-zinc-900/3 flux-band:dark:bg-black/15'),
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
