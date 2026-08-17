@blaze(fold: true)

@props([
    'size' => null,
])

@php
$classes = Flux::classes()
    ->add('[:where(&)]:bg-white dark:[:where(&)]:bg-white/10')
    ->add('border [:where(&)]:border-zinc-200 dark:[:where(&)]:border-white/10')
    ->add(match ($size) {
        default => '[:where(&)]:p-6 [:where(&)]:rounded-xl',
        'sm' => '[:where(&)]:p-4 [:where(&)]:rounded-lg',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card>
    {{ $slot }}
</div>
