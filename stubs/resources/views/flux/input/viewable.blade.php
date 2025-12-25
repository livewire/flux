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
    x-on:click="toggle"
    x-bind:data-viewable-open="open"
    aria-label="{{ __('Toggle password visibility') }}"
    x-init="init"
>
    <flux:icon.eye-slash variant="micro" class="hidden [[data-viewable-open]>&]:block" />
    <flux:icon.eye variant="micro" class="block [[data-viewable-open]>&]:hidden" />
</flux:button>

@assets
<script>
    window.addEventListener('alpine:init', () => {
        Alpine.data('fluxInputViewable', () => ({
            open: false,

            toggle() {
                this.open = !this.open;
                const input = this.$el.closest('[data-flux-input]').querySelector('input');
                input.setAttribute('type', this.open ? 'text' : 'password');
            },

            init() {
                // Make the input type "durable" (immune to Livewire morph manipulations)
                const input = this.$el.closest('[data-flux-input]')?.querySelector('input');

                if (!input) return;

                const observer = new MutationObserver(() => {
                    const type = this.open ? 'text' : 'password';
                    if (input.getAttribute('type') === type) return;
                    input.setAttribute('type', type);
                });

                observer.observe(input, { attributes: true, attributeFilter: ['type'] });
            }
        }))
    })
</script>
@endassets
