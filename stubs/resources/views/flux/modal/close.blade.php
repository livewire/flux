@props(['class' => ''])

@blaze

<ui-close data-flux-modal-close {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</ui-close>
