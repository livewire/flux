@pure

@php
$classes = Flux::classes()
    ->add('[:where(&)]:min-w-48 p-[.3125rem]')
    ->add('rounded-lg shadow-xs')
    ->add('border border-zinc-200 dark:border-zinc-600')
    ->add('bg-white dark:bg-zinc-700')
    ;
@endphp

<nav {{ $attributes->class($classes) }} popover="manual" data-flux-navmenu>
    {{ $slot }}
</nav>
