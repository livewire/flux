@blaze(fold: true)

@props([
    'container' => null,
    'inset' => false,
])

@php
$classes = Flux::classes('[grid-area:main]')
    ->add($inset ? 'p-6 lg:p-10' : 'p-6 lg:p-8')
    ->add($inset ? 'min-w-0 min-h-0 [:where(&)]:bg-white dark:[:where(&)]:bg-zinc-800 lg:m-2 lg:rounded-xl lg:border lg:[:where(&)]:border-zinc-200 lg:shadow-xs dark:lg:[:where(&)]:border-zinc-700' : '')
    ->add($inset ? 'lg:overflow-y-auto lg:overscroll-contain' : '')
    ->add('[[data-flux-container]_&]:px-0') // If there is a wrapping container, let IT handle the x padding...
    ->add($container && ! $inset ? 'mx-auto w-full [:where(&)]:max-w-7xl' : '')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-main @if ($inset) data-flux-main-inset @endif>
    <?php if ($container && $inset): ?>
        <div class="mx-auto w-full [:where(&)]:max-w-7xl">
            {{ $slot }}
        </div>
    <?php else: ?>
        {{ $slot }}
    <?php endif; ?>
</div>
