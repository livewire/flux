@blaze(fold: true)

@php
// The root card supplies the body treatment and surface. CSS scopes these variants to that card so a
// nested card's defaults cannot pick up an ancestor's explicitly passed Blade props.
$classes = Flux::classes()
    ->add('flux-card-panel:border flux-card-panel:[:where(&)]:border-transparent flux-card-panel:before:inset-ring')
    ->add('flux-card-panel:flux-card-well:[:where(&)]:bg-zinc-50 flux-card-panel:flux-card-white:dark:[:where(&)]:bg-black/15')
    ->add('flux-card-panel:flux-card-raised:[:where(&)]:bg-white flux-card-panel:flux-card-raised:dark:[:where(&)]:bg-white/4 flux-card-panel:flux-card-outline:dark:[:where(&)]:bg-white/4')
    ->add('flux-card-inset:[:where(&)]:before:inset-ring-zinc-900/8')
    ->add('flux-card-inset:flux-card-well:dark:[:where(&)]:before:inset-ring-white/8 flux-card-inset:flux-card-raised:dark:[:where(&)]:before:inset-ring-white/10')
    ->add('flux-card-inset:flux-card-well:[:where(&)]:before:inset-shadow-[0_1.5px_2.5px_rgb(0_0_0/0.05)] flux-card-inset:flux-card-well:dark:[:where(&)]:before:inset-shadow-none flux-card-inset:flux-card-raised:[:where(&)]:shadow-xs')
    // Flush panels share the card's edge. The pseudo-element lets flux.css clip the overlapping shadow.
    ->add('flux-card-flush:[:where(&)]:before:inset-ring-zinc-200 flux-card-flush:dark:[:where(&)]:before:inset-ring-white/10 flux-card-flush:[:where(&)]:before:shadow-xs flux-card-flush:dark:[:where(&)]:before:shadow-none')
    ->add('flux-card-flush:has-[>[data-flux-card-bleed]]:[:where(&)]:before:inset-ring-zinc-900/10 flux-card-flush:dark:has-[>[data-flux-card-bleed]]:[:where(&)]:before:inset-ring-white/10')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-body>
    {{ $slot }}
</div>
