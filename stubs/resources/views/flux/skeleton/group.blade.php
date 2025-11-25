@blaze

@props([
    'animate' => null,
])

<div {{ $attributes->class($classes) }} data-flux-skeleton-group>
    {{ $slot }}
</div>