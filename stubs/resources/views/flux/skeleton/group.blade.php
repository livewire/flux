@blaze

@props([
    'animate' => null,
])

<div {{ $attributes }} data-flux-skeleton-group>
    {{ $slot }}
</div>