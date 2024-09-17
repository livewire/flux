@props([
    'position' => 'top',
    'align' => 'center',
    'content' => null,
    'kbd' => null,
])

<ui-tooltip position="{{ $position }} {{ $align }}" {{ $attributes }} data-flux-tooltip>
    {{ $slot }}

    <?php if ($content): ?>
        <flux:tooltip.content>{{ $content }}</flux:tooltip.content>
    <?php endif; ?>
</ui-tooltip>
