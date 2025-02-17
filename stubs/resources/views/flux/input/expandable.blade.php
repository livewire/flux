@php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-mr-1',
    'square' => true,
    'size' => null,
]);
@endphp

<flux:button
    :$attributes
    :size="$size === 'sm' ? 'xs' : 'sm'"
    x-on:click="$el.closest('[data-flux-input]').querySelector('input').value = ''"
>
    <flux:icon.chevron-down variant="micro" />
</flux:button>
