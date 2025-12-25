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
    x-on:click="copy"
    x-bind:data-copyable-copied="copied"
    aria-label="{{ __('Copy to clipboard') }}"
>
    <flux:icon.clipboard-document-check variant="mini" class="hidden [[data-copyable-copied]>&]:block" />
    <flux:icon.clipboard-document variant="mini" class="block [[data-copyable-copied]>&]:hidden" />
</flux:button>

@assets
<script>
    window.addEventListener('alpine:init', () => {
        Alpine.data('fluxInputCopyable', () => ({
            copied: false,

            copy() {
                this.copied = !this.copied;
                
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(
                        this.$el.closest('[data-flux-input]').querySelector('input').value
                    );
                }
                
                setTimeout(() => this.copied = false, 2000);
            }
        }))
    })
</script>
@endassets
