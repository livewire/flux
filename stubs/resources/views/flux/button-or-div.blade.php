@props([
    'as' => null,
])

<?php if ($as === 'button'): ?>
    <button type="button" {{ $attributes }}>
        {{ $slot }}
    </button>
<?php else: ?>
    <div {{ $attributes }}>
        {{ $slot }}
    </div>
<?php endif; ?>
