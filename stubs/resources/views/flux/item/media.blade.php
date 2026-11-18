@blaze(fold: true)

@php
// Always in the leading column, spanning every row so it centers on the text, 12px from it. A flex row, so a
// checkbox and an avatar can sit side by side...
$classes = Flux::classes()
    ->add('col-start-1 row-span-full self-center me-3 flex items-center gap-3')
    // With actions stacked below, centering on everything would float it; it centers on the heading and subheading...
    ->add('flux-item-stacked:row-[2/4]')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-item-media>
    {{ $slot }}
</div>
