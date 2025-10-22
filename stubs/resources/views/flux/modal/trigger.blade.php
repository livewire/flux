@blaze

@props([
    'shortcut' => null,
    'name' => null,
])

<div
    {{ $attributes->class('contents') }}
    x-data
    x-on:click="$el.querySelector('button[disabled]') || $dispatch('modal-show', { name: '{{ $name }}' })"
    @if ($shortcut)
        x-on:keydown.{{ $shortcut }}.document="$event.preventDefault(); $dispatch('modal-show', { name: '{{ $name }}' })"
    @endif
    data-flux-modal-trigger
>
    {{ $slot }}
</div>
