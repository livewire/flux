@php
$attributes = Flux::restorePassThroughProps($attributes, ['tooltip-kbd', 'tooltip-position']);
@endphp

@props([
    'tooltipPosition' => 'top',
    'tooltipKbd' => null,
    'tooltip' => null,
])

<?php if ($tooltip): ?>
    <flux:tooltip :content="$tooltip" :position="$tooltipPosition" :kbd="$tooltipKbd">
        {{ $slot }}
    </flux:tooltip>
<?php else: ?>
    {{ $slot }}
<?php endif; ?>
