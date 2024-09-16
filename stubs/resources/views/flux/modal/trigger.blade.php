@props([
    'shortcut' => null,
    'name' => null,
])

<div
    {{ $attributes->class('contents') }}
    x-on:click="$dispatch('open-modal', { name: '{{ $name }}' })"
    @if ($shortcut)
        x-on:keydown.{{ $shortcut }}.document="$dispatch('open-modal', { name: '{{ $name }}' })"
    @endif
    data-flux-modal-trigger
>
    {{ $slot }}
</div>
