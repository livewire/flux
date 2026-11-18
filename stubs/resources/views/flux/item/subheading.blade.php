@blaze(fold: true)

@php
// Its own type rather than flux:text's: a step smaller, tucked 2px under the heading...
$classes = Flux::classes()
    ->add('col-start-2 row-start-3 min-w-0 break-words mt-0.5')
    ->add('[:where(&)]:text-[.8125rem] [:where(&)]:leading-[1.125rem] [:where(&)]:font-normal')
    ->add('[:where(&)]:text-zinc-500 [:where(&)]:dark:text-white/70')
    ;
@endphp

<p {{ $attributes->class($classes) }} data-flux-item-subheading>{{ $slot }}</p>
