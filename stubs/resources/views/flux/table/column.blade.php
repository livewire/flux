@blaze

@props([
    'direction' => null,
    'sortable' => false,
    'sorted' => false,
    'align' => 'start',
    'sticky' => false,
])

@php
$classes = Flux::classes()
    ->add('py-3 px-3 first:ps-0 last:pe-0')
    ->add('text-start text-sm font-medium text-zinc-800 dark:text-white')
    ->add('border-b border-zinc-800/10 dark:border-white/20')
    ->add(match($align) {
        'center' => 'group/center-align',
        'end' => 'group/end-align',
        // Right is @deprecated but needed for backwards compatibility...
        'right' => 'group/end-align',
        default => '',
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
    // If the last column is sortable, remove the right negative margin that the sortable applies to itself, as the
    // negative margin caused the last column to overflow the table creating an unnecessary horizontal scrollbar...
    ->add('**:data-flux-table-sortable:last:me-0')
    ;
@endphp

<th {{ $attributes->class($classes) }} data-flux-column>
    <?php if ($sortable): ?>
        <div class="flex in-[.group\/center-align]:justify-center in-[.group\/end-align]:justify-end">
            <flux:table.sortable :$sorted :direction="$direction">
                <div>{{ $slot }}</div>
            </flux:table.sortable>
        </div>
    <?php else: ?>
        <div class="flex in-[.group\/center-align]:justify-center in-[.group\/end-align]:justify-end">{{ $slot }}</div>
    <?php endif; ?>
</th>
