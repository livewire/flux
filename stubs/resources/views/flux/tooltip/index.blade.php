@props([
    'interactive' => null,
    'position' => 'top',
    'align' => 'center',
    'content' => null,
    'kbd' => null,
])

<ui-tooltip position="{{ $position }} {{ $align }}" {{ $attributes }} data-flux-tooltip @if ($interactive) interactive @endif>
    {{ $slot }}

    <?php if ($content !== null): ?>
        <flux:tooltip.content :$kbd>{{ $content }}</flux:tooltip.content>
    <?php endif; ?>
</ui-tooltip>
