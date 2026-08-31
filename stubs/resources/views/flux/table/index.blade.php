@blaze(fold: true)

@props([
    'paginate' => null,
    'bleed' => false,
])

@php
$classes = Flux::classes()
    ->add('[:where(&)]:min-w-full table-fixed border-separate border-spacing-0 isolate')
    ->add('text-zinc-800')
    // We want whitespace-nowrap for the table, but not for modals and dropdowns...
    ->add('whitespace-nowrap [&_dialog]:whitespace-normal [&_[popover]]:whitespace-normal')
    ->add($bleed ? [
        '[&_[data-flux-column]:first-child]:ps-[var(--flux-bleed)]',
        '[&_[data-flux-cell]:first-child]:ps-[var(--flux-bleed)]',
        '[&_[data-flux-column]:last-child]:pe-[var(--flux-bleed)]',
        '[&_[data-flux-cell]:last-child]:pe-[var(--flux-bleed)]',
    ] : '')
    ;

$containerClasses = Flux::classes()
    ->add('flex flex-col')
    ->add($bleed ? '-mx-[var(--flux-bleed)]' : '')
    ->add($attributes->pluck('container:class'))
    ;
@endphp

<div class="{{ $containerClasses }}">
    {{ $header ?? '' }}

    <ui-table-scroll-area class="overflow-auto">
        <table {{ $attributes->class($classes) }} data-flux-table>
            {{ $slot }}
        </table>
    </ui-table-scroll-area>

    {{ $footer ?? '' }}

    <?php if ($paginate): ?>
        <?php $paginationAttributes = Flux::attributesAfter('pagination:', $attributes, [
            'paginator' => $paginate,
            'class' => Flux::classes()
                ->add('shrink-0')
                ->add($bleed ? 'px-[var(--flux-bleed)]' : ''),
        ]); ?>
        <flux:pagination :attributes="$paginationAttributes" />
    <?php endif; ?>
</div>
