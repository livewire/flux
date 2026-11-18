@blaze(fold: true)

@php
// Three columns: leading content, text, then actions. The text sits in rows 2 and 3, between two 1fr rows that
// soak up any spare height, so heading and subheading center as one block. Row 4 stays empty unless a narrow item
// stacks its actions there (see flux-item-stacked), and the item is a container so its own width decides that.
// min-h is on the content box (box-content), so the text area is at least as tall as a small button whether or
// not there are actions, and borders or dividers never eat into it...
$classes = Flux::classes()
    ->add('@container grid grid-cols-[auto_1fr_auto] grid-rows-[1fr_auto_auto_auto_1fr]')
    ->add('box-content [:where(&)]:min-h-8 [:where(&)]:ps-4 [:where(&)]:pe-3.5 [:where(&)]:py-3')
    // flux:item.media leads the row. Anything else placed before the heading does too, so stray content lands
    // somewhere sensible rather than in the top spacer row...
    ->add('[:where(&>:has(~[data-flux-item-heading]))]:col-start-1 [:where(&>:has(~[data-flux-item-heading]))]:row-span-full')
    ->add('[:where(&>:has(~[data-flux-item-heading]))]:self-center [:where(&>:has(~[data-flux-item-heading]))]:me-3')
    // Outside a group, an item draws the group's surface itself, so a lone item needs no wrapper...
    ->add('flux-item-standalone:[:where(&)]:rounded-xl flux-item-standalone:[:where(&)]:border flux-item-standalone:bg-clip-padding dark:flux-item-standalone:bg-clip-border')
    ->add('flux-item-standalone:[:where(&)]:border-zinc-900/10 dark:flux-item-standalone:[:where(&)]:border-white/10')
    ->add('flux-item-standalone:[:where(&)]:bg-white dark:flux-item-standalone:[:where(&)]:bg-white/10')
    ->add('flux-item-standalone:[:where(&)]:shadow-xs dark:flux-item-standalone:[:where(&)]:shadow-none')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-item>
    {{ $slot }}
</div>
