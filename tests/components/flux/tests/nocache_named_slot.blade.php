@cached
@props([
    'counter',
    'icon' => null,
])

@php($counter->increment())

<flux:nocache>
<?php if (is_string($icon) && $icon !== ''): ?>
Was just a prop: {{ $icon }}
<?php else: ?>
{{ $icon }}
<?php endif; ?>
</flux:nocache>

