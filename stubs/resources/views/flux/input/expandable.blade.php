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
    x-data="expandable"
    x-on:click="expand"
>
    <flux:icon.chevron-down variant="micro" />
</flux:button>

@assets
<script>
    window.addEventListener('alpine:init', () => {
        Alpine.data('expandable', () => ({
            expand() {
                this.$el.closest('[data-flux-input]').querySelector('input').value = '';
            }
        }))
    })
</script>
@endassets
