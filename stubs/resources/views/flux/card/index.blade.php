@blaze(fold: true)

@props([
    'body' => 'seamless',
    'variant' => null,
    'divider' => null,
    'size' => null,
])

@php
// Divided and separated cards have a white body. Rather than painting the body (which would poke out of this
// card's corners), the card itself is white and its header and footer carry the variant's color instead.
// Filled cards are the exception: with no ring to frame a white body, their fill has to stay whole...
$coloredBands = in_array($body, ['divided', 'separated']) && $variant !== 'filled';

$classes = Flux::classes()
    // A colored header or footer would darken an inset ring wherever it overlaps it, so their ring sits outside.
    // It's also the only thing giving the white body an edge, so it matches the outline variant's weight...
    ->add(match (true) {
        $variant === 'filled' => '',
        $coloredBands => 'ring ring-zinc-900/14 dark:ring-white/10',
        default => 'inset-ring',
    })
    ->add(match ($variant) {
        'filled' => '',
        'muted' => 'inset-ring-zinc-900/3 dark:inset-ring-white/5',
        'soft' => 'inset-ring-zinc-900/3 dark:inset-ring-white/5',
        'outline' => 'inset-ring-zinc-900/14 dark:inset-ring-white/15',
        default => 'inset-ring-zinc-900/14 shadow-xs dark:inset-ring-white/10 dark:shadow-none',
        // @todo: Add :where statements back in when done...
    })
    ->add($coloredBands ? 'bg-white dark:bg-white/10' : match ($variant) {
        'filled' => 'bg-zinc-900/4 dark:bg-white/10',
        'muted' => 'bg-zinc-900/4 dark:bg-white/7',
        'soft' => 'bg-zinc-900/2 dark:bg-white/5',
        'outline' => 'bg-transparent dark:bg-transparent',
        default => 'bg-white dark:bg-white/10',
    })
    ;

// Sizing lives in flux.css, keyed by these. A card with no size gets one of two defaults there, depending on
// whether it has parts. "body-variant" because a plain [data-flux-card-body] already means <flux:card.body>...
$attributes = $attributes->merge([
    'data-flux-card-body-variant' => $body,
]);

if ($size) {
    $attributes = $attributes->merge([
        'data-flux-card-size' => $size,
    ]);
}
@endphp

<div
    {{ $attributes->class($classes) }}
    data-flux-card
>
    {{ $slot }}
</div>
