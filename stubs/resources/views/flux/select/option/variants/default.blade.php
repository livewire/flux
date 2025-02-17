@props([
    'value' => null,
])

<option
    {{ $attributes }}
    @if (isset($value)) value="{{ $value }}" @endif
    @if (isset($value)) wire:key="{{ $value }}" @endif
>{{ $slot }}</option>