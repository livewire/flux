@blaze(fold: true)

@props([
    'variant' => 'outline',
    'size' => null,
])

@php
$classes = Flux::classes()
    ->add('border')
    ->add(match ($variant) {
        'soft' => '[:where(&)]:bg-black/[0.02] [:where(&)]:border-black/[0.025] dark:[:where(&)]:bg-white/[0.06] dark:[:where(&)]:border-white/[0.065]',
        default => '[:where(&)]:bg-white [:where(&)]:border-zinc-200 dark:[:where(&)]:bg-white/10 dark:[:where(&)]:border-white/10',
    })
    ->add(match ($size) {
        default => '[:where(&)]:p-6 [:where(&)]:rounded-xl [--flux-card-padding:1.5rem]',
        'sm' => '[:where(&)]:p-4 [:where(&)]:rounded-lg [--flux-card-padding:1rem]',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card>
    {{ $slot }}
</div>
