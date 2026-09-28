@blaze(fold: true)

@props(['size' => null])

@php
// These variants match only a card's own bands. Parts inside a body remain bare.
$classes = Flux::classes()
    ->add('flux-card-divided:flux-card-muted:[:where(&)]:bg-zinc-900/4 flux-card-divided:flux-card-muted:dark:[:where(&)]:bg-black/20')
    ->add('flux-card-divided:flux-card-soft:[:where(&)]:bg-zinc-900/3 flux-card-divided:flux-card-soft:dark:[:where(&)]:bg-black/35')
    ->add('flux-card-separated:flux-card-muted:[:where(&)]:bg-zinc-900/4 flux-card-separated:flux-card-muted:dark:[:where(&)]:bg-black/20')
    ->add('flux-card-separated:flux-card-soft:[:where(&)]:bg-zinc-900/3 flux-card-separated:flux-card-soft:dark:[:where(&)]:bg-black/35')
    ->add('flux-card-separated:flux-card-standard:[:where(&)]:bg-zinc-900/3 flux-card-separated:flux-card-standard:dark:[:where(&)]:bg-black/15')
    ->add('flux-card-separated:flux-card-filled:[:where(&)]:bg-zinc-900/2 flux-card-separated:flux-card-filled:[:where(&)]:ring-zinc-900/2 flux-card-separated:flux-card-filled:dark:[:where(&)]:bg-black/15 flux-card-separated:flux-card-filled:dark:[:where(&)]:ring-black/15 flux-card-separated:flux-card-filled:ring flux-card-separated:flux-card-filled:[clip-path:inset(-1px_-1px_0_-1px)]')
    ->add('flux-card-divided:not-last:border-b flux-card-divided:not-last:[:where(&)]:border-zinc-900/5 flux-card-divided:not-last:dark:[:where(&)]:border-white/10')
    ->add('flux-card-divided:flux-card-divider-inset:not-last:border-transparent flux-card-divided:flux-card-divider-inset:not-last:dark:border-transparent flux-card-divided:flux-card-divider-inset:not-last:relative flux-card-divided:flux-card-divider-inset:not-last:after:absolute flux-card-divided:flux-card-divider-inset:not-last:after:inset-x-[var(--flux-card-part-px)] flux-card-divided:flux-card-divider-inset:not-last:after:-bottom-px flux-card-divided:flux-card-divider-inset:not-last:after:border-b flux-card-divided:flux-card-divider-inset:not-last:[:where(&)]:after:border-zinc-900/5 flux-card-divided:flux-card-divider-inset:not-last:dark:[:where(&)]:after:border-white/10')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-header data-flux-card-standalone @if ($size) data-flux-card-size="{{ $size }}" @endif>
    {{ $slot }}
</div>
