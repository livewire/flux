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
    ->add('text-zinc-500 dark:text-white/70')
    ;
@endphp
{{-- NOTE: It's important that this file has NO newline at the end of the file. --}}
<div {{ $attributes->class($classes) }} data-flux-text>{{ $slot }}</div>