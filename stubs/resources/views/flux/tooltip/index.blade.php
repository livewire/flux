@props([
    'position' => 'top',
    'content' => null,
    'kbd' => null,
])

<ui-tooltip position="{{ $position }}" {{ $attributes }} data-flux-tooltip>
    {{ $slot }}

    <?php if ($content): ?>
        <flux:tooltip.content>{{ $content }}</flux:tooltip.content>
    <?php endif; ?>
</ui-tooltip>
