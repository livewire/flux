@blaze

@props([
    'as' => null,
])

<?php if ($as === 'button'): ?>
    <button {{ $attributes->merge(['type' => 'button']) }}>
        {{ $slot }}
    </button>
<?php else: ?>
    <div {{ $attributes }}>
        {{ $slot }}
    </div>
<?php endif; ?>
