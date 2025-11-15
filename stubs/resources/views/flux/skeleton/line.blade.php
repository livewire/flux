@blaze

@props([
    'size' => 'base',
])

@php
$classes = Flux::classes()
    ->add('[:where(&)]:w-full')
    ->add(match ($size) {
        'base' => '[:where(&)]:h-5 py-[3px]',
        'lg' => 'h-6 py-[2px]',
        'xl' => 'h-8 py-[3px]',
    });
@endphp

<div {{ $attributes->class($classes) }} data-flux-skeleton-line>
    <div class="h-full [:where(&)]:rounded [:where(&)]:bg-zinc-400/20">{{ $slot }}</div>
</div>