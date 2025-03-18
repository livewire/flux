@php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-me-1 [[data-flux-input]:has(input:placeholder-shown)_&]:hidden [[data-flux-input]:has(input[disabled])_&]:hidden',
    'square' => true,
    'size' => null,
]);
@endphp

<flux:button
    :$attributes
    :size="$size === 'sm' || $size === 'xs' ? 'xs' : 'sm'"
    x-data
    x-on:click="let input = $el.closest('[data-flux-input]').querySelector('input'); input.value = ''; input.dispatchEvent(new Event('input', { bubbles: false })); input.dispatchEvent(new Event('change', { bubbles: false })); input.focus()"
    tabindex="-1"
    aria-label="Clear input"
    data-flux-clear-button
>
    <flux:icon.x-mark variant="micro" />
</flux:button>
