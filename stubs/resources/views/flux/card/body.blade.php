@blaze(fold: true)

@aware(['body' => 'seamless', 'variant' => null])

@props([
    'body' => 'seamless',
    'variant' => null,
])

@php
// A panel sits one tone away from the band around it. A tinted card's band already makes a white panel read
// as raised; a white card's can't, so there the panel is a recessed well instead. Dark mode keeps the same
// shapes: a well is darker than its band, a raised panel lighter, and either way its edge is lighter than
// its fill so the edge still reads...
$well = in_array($variant, [null, 'outline'], true);

$fill = $well ? 'bg-zinc-50 dark:bg-black/15' : 'bg-white dark:bg-white/5';
$edge = $well ? 'dark:before:inset-ring-white/10' : 'dark:before:inset-ring-white/15';

// A panel's corners follow the card's size, so they live in flux.css with the rest of its geometry...
$classes = Flux::classes()
    ->add(match ($body) {
        // A panel's edge is drawn on a pseudo-element over a transparent border, so it sits over the band (see
        // flux.css, where a flush panel also overlaps the card's edge). Only the colors are decided here. A well's
        // shadow rides there too, so it starts under the edge rather than just inside it and the edge stays crisp.
        // A flush panel's shadow does as well, so flux.css can keep it from spilling past the card's sides...
        'inset' => [
            $fill,
            $edge,
            'border border-transparent before:inset-ring before:inset-ring-zinc-900/8',
            $well ? 'before:inset-shadow-[0_1.5px_2.5px_rgb(0_0_0/0.05)] dark:before:inset-shadow-none' : 'shadow-xs',
        ],
        // Experiment: a flush panel's edge lies over the card's own wherever it meets the card's sides, so a
        // translucent edge came out darker there than along the bands. An opaque one covers the card's instead,
        // so it's one color all the way around. Over bled media it goes back to translucent, so it shades the
        // media's outermost pixel instead of drawing a light line across it (see <flux:card.bleed>)...
        'flush' => [
            $fill,
            'border border-transparent before:inset-ring before:inset-ring-zinc-200 dark:before:inset-ring-zinc-700 before:shadow-xs dark:before:shadow-none',
            'has-[>[data-flux-card-bleed]]:before:inset-ring-zinc-900/10 dark:has-[>[data-flux-card-bleed]]:before:inset-ring-white/10',
        ],
        default => '',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-body>
    {{ $slot }}
</div>
