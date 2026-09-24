@blaze(fold: true)

@aware(['body' => 'seamless', 'variant' => null, 'size'])

@props([
    'body' => 'seamless',
    'variant' => null,
    'size' => 'md',
])

@php
// A panel sits one tone away from the band around it. A tinted card's band already makes a white panel read
// as raised; a white card's can't, so there the panel is a recessed well instead. Dark mode keeps the same
// shapes: a well is darker than its band, a raised panel lighter, and either way its edge is lighter than
// its fill so the edge still reads...
$fill = match ($variant) {
    null, 'outline' => 'bg-zinc-50 dark:bg-black/15',
    default => 'bg-white dark:bg-white/5 shadow-xs',
};

$edge = match ($variant) {
    null, 'outline' => 'dark:before:inset-ring-white/10',
    default => 'dark:before:inset-ring-white/15',
};

$classes = Flux::classes()
    ->add(match ($body) {
        'seamless', 'divided', 'separated' => '',
        'inset' => match ($size) {
            'xl' => 'rounded-xl',
            'lg' => 'rounded-lg',
            'md' => 'rounded-lg',
            'sm' => 'rounded-md',
        },
        'flush' => match ($size) {
            'xl' => 'rounded-2xl',
            'lg' => 'rounded-xl',
            'md' => 'rounded-xl',
            'sm' => 'rounded-lg',
        },
    })
    ->add(match ($body) {
        // A panel's edge is drawn on a pseudo-element over a transparent border, so it sits over the band (see
        // flux.css, where a flush panel also overlaps the card's edge). Only the colors are decided here. A well's
        // shadow rides there too, so it starts under the edge rather than just inside it and the edge stays crisp...
        'inset' => [
            in_array($variant, ['outline', null]) ? 'before:inset-shadow-[0_1.5px_2.5px_rgb(0_0_0/0.05)] dark:before:inset-shadow-none' : '',
            $fill,
            'border border-transparent before:inset-ring before:inset-ring-zinc-900/10',
            $edge,
        ],
        'flush' => [$fill, $edge, 'border border-transparent before:inset-ring before:inset-ring-zinc-900/10 before:shadow-xs dark:before:shadow-none'],
        default => ''
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-body>
    {{ $slot }}
</div>
