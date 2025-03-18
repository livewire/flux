@php $iconVariant = $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'iconVariant' => 'micro',
    'icon' => 'x-mark',
])

@php
// When using the outline icon variant, we need to size it down to match the default icon sizes...
$iconClasses = Flux::classes()->add($iconVariant === 'outline' ? 'size-4' : '');

$classes = Flux::classes()
    ->add('p-1 -my-1 -me-1 opacity-50 hover:opacity-100')
    ;
@endphp

<button type="button" {{ $attributes->class($classes) }} data-flux-badge-close>
    <?php if (is_string($icon) && $icon !== ''): ?>
        <flux:icon :$icon :variant="$iconVariant" :class="$iconClasses" />
    <?php else: ?>
        {{ $icon }}
    <?php endif; ?>
</button>
