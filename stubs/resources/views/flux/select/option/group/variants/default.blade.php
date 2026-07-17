@blaze(fold: true)

@props([
    'label',
])

<optgroup {{ $attributes }} label="{{ $label }}">{{ $slot }}</optgroup>
