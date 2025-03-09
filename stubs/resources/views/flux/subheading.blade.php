@props([
    'size' => null,
])

@php
$classes = Flux::classes()
    ->add(match ($size) {
        'xl' => 'text-lg',
        'lg' => 'text-base',
        default => 'text-sm',
        'sm' => 'text-xs',
    })
    ->add('[:where(&)]:text-zinc-500 [:where(&)]:dark:text-white/70')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-subheading>
    {{ $slot }}
</div>
