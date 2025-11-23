@blaze

@php $srOnly = $srOnly ??= $attributes->pluck('sr-only'); @endphp

@props([
    'srOnly' => null,
])

@php
$classes = Flux::classes()
    ->add('text-sm text-zinc-500 dark:text-white/60')
    ->add($srOnly ? 'sr-only' : '')
    ;
@endphp

<ui-description {{ $attributes->class($classes) }} data-flux-description>
    {{ $slot }}
</ui-description>
