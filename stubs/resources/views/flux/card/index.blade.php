@blaze(fold: true)

@props([
    'body' => 'seamless',
    'variant' => null,
    'divider' => null,
    'size' => null,
    'highlight' => true,
])

@php
// Divided and separated cards have a white body. Rather than painting the body (which would poke out of this
// card's corners), the card itself is white and its header and footer carry the variant's color instead.
// Filled cards are the exception: with no edge to frame a white body, their fill has to stay whole...
$coloredBands = in_array($body, ['divided', 'separated']) && $variant !== 'filled';

$classes = Flux::classes()
    // Every card has a 1px edge inside its box. In light mode the fill is clipped to the inside of it, so the edge
    // sits over the page and keeps its contrast on any background (see flux.css); muted and soft edges include
    // their fill's tint for that reason. In dark mode the edge lies over the fill instead. Filled has no edge to
    // show. A divided or separated card's white body needs a real edge whatever the variant, so those match the
    // outline variant's weight...
    ->add($variant === 'filled' ? 'border border-transparent' : 'border bg-clip-padding dark:bg-clip-border')
    ->add($coloredBands ? 'border-zinc-900/10 dark:border-white/10' : match ($variant) {
        'filled' => '',
        'muted' => 'border-zinc-900/10 dark:border-white/12',
        'soft' => 'border-zinc-900/7 dark:border-white/5',
        'outline' => 'border-zinc-900/10 dark:border-white/15',
        default => 'border-zinc-900/10 dark:border-white/10',
        // @todo: Add :where statements back in when done...
    })
    ->add($variant === null ? 'shadow-xs dark:shadow-none' : '')
    // Experiment: a faint highlight just inside the edge, drawn over the card's parts so bands and panels that
    // reach the edge don't cover it. Its corners follow the inside of the edge rather than the outside, and it
    // fades out toward the bottom, like light falling from above. Filled has no edge for it to follow, and dark
    // mode goes without. :highlight="false" turns it off...
    ->add(! $highlight || $variant === 'filled' ? '' : 'relative after:pointer-events-none after:absolute after:inset-0 after:rounded-[calc(var(--flux-card-radius)-1px)] after:inset-ring after:inset-ring-white/25 dark:after:hidden after:[mask-image:linear-gradient(to_bottom,black,transparent)]')
    ->add($coloredBands ? 'bg-white dark:bg-white/10' : match ($variant) {
        'filled' => 'bg-zinc-900/3 dark:bg-white/10',
        'muted' => 'bg-zinc-900/4 dark:bg-white/7',
        'soft' => 'bg-zinc-900/2 dark:bg-white/5',
        'outline' => 'bg-transparent',
        default => 'bg-white dark:bg-white/10',
    })
    ;

// Sizing lives in flux.css, keyed by these. A card with no size is md there. "body-variant" because a plain
// [data-flux-card-body] already means <flux:card.body>...
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
