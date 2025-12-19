@blaze

@props([
    'align' => 'start',
    'variant' => null,
    'sticky' => false,
])

@php
$classes = Flux::classes()
    ->add('py-3 px-3 first:ps-0 last:pe-0 text-sm')
    ->add(match($align) {
        'center' => 'text-center',
        'end' => 'text-end',
        default => '',
    })
    ->add(match ($variant) {
        'strong' => 'font-medium text-zinc-800 dark:text-white',
        default => 'text-zinc-500 dark:text-zinc-300',
    })
    ->add($sticky ? [
        'z-10',
        'first:sticky first:left-0',
        'last:sticky last:right-0',
        'first:after:w-8 first:after:absolute first:after:inset-y-0 first:after:right-0 first:after:translate-x-full first:after:pointer-events-none',
        'last:after:w-8 last:after:absolute last:after:inset-y-0 last:after:left-0 last:after:-translate-x-full last:after:pointer-events-none',
        'in-data-scrolled-right:first:after:inset-shadow-[8px_0px_8px_-8px_rgba(0,0,0,0.05)]',
        'in-data-scrolled-left:last:after:inset-shadow-[-8px_0px_8px_-8px_rgba(0,0,0,0.05)]',
    ]: '')
    ->add('not-in-[tr:first-child]:border-t border-zinc-800/10 dark:border-white/20')
    ;
@endphp

<td {{ $attributes->class($classes) }} data-flux-cell>
    {{ $slot }}
</td>
