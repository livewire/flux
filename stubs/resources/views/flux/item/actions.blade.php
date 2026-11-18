@blaze(fold: true)

@php
// Spans every row of the item, so it centers on the text block however tall either side gets...
$classes = Flux::classes()
    ->add('col-start-3 row-span-full self-center justify-self-end flex items-center gap-2')
    // A margin rather than a column gap, so an item without actions gets its full width for text...
    ->add('ms-4')
    // Stacked, they drop to their own row under the text, lined up with the heading...
    ->add('flux-item-stacked:col-[2/-1] flux-item-stacked:row-[4] flux-item-stacked:justify-self-start flux-item-stacked:ms-0 flux-item-stacked:mt-3')
    // ...and wrap, so several buttons never run past the edge...
    ->add('flux-item-stacked:flex-wrap')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-item-actions>
    {{ $slot }}
</div>
