@blaze

@php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-me-1',
    'square' => true,
    'size' => null,
]);
@endphp

<flux:button
    :$attributes
    :size="$size === 'sm' || $size === 'xs' ? 'xs' : 'sm'"
    x-data="fluxInputViewable"
    x-on:click="toggle()"
    x-bind:data-viewable-open="open"
    aria-label="{{ __('Toggle password visibility') }}"
>
    <flux:icon.eye-slash variant="micro" class="hidden [[data-viewable-open]>&]:block" />
    <flux:icon.eye variant="micro" class="block [[data-viewable-open]>&]:hidden" />
</flux:button>
