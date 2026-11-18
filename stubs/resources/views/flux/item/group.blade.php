@blaze(fold: true)

@php
// The same surface as a default card, with a faint rule between each item...
$classes = Flux::classes()
    ->add('[:where(&)]:rounded-xl border bg-clip-padding dark:bg-clip-border')
    ->add('[:where(&)]:border-zinc-900/10 dark:[:where(&)]:border-white/10')
    ->add('[:where(&)]:bg-white dark:[:where(&)]:bg-white/10')
    ->add('[:where(&)]:shadow-xs dark:[:where(&)]:shadow-none')
    ->add('divide-y [:where(&)]:divide-zinc-900/5 dark:[:where(&)]:divide-white/10')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-item-group>
    {{ $slot }}
</div>
