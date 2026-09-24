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
    // Every card has a 1px edge inside its box, with the fill clipped to the inside of it so the edge sits over
    // the page and keeps its contrast on any background (see flux.css). Filled has no edge to show. Muted and
    // soft edges include their fill's tint, since they don't sit on top of it. A divided or separated card's
    // white body needs a real edge whatever the variant, so those match the outline variant's weight...
    ->add($variant === 'filled' ? 'border border-transparent' : 'border bg-clip-padding dark:bg-clip-border')
    ->add($coloredBands ? 'border-zinc-900/14 dark:border-white/10' : match ($variant) {
        'filled' => '',
        'muted' => 'border-zinc-900/10 dark:border-white/12',
        'soft' => 'border-zinc-900/7 dark:border-white/10',
        'outline' => 'border-zinc-900/14 dark:border-white/15',
        default => 'border-zinc-900/14 dark:border-white/10',
        // @todo: Add :where statements back in when done...
    })
    ->add($variant === null ? 'shadow-xs dark:shadow-none' : '')
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
