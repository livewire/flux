@props([
    'container' => null,
])

<?php if ($container): ?>
    <flux:container class="{!! $attributes->get('class') !!}">
        {{ $slot }}
    </flux:container>
<?php else: ?>
    {{ $slot }}
<?php endif; ?>

