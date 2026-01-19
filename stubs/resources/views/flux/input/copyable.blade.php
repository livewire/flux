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
    x-data="fluxInputCopyable"
    x-on:click="copy()"
    x-bind:data-copyable-copied="copied"
    aria-label="{{ __('Copy to clipboard') }}"
>
    <flux:icon.clipboard-document-check variant="mini" class="hidden [[data-copyable-copied]>&]:block" />
    <flux:icon.clipboard-document variant="mini" class="block [[data-copyable-copied]>&]:hidden" />
</flux:button>
