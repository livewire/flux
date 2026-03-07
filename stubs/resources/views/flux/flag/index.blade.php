@blaze(fold: true, memo: true)

@props([
    'flag' => null,
    'name' => null,
])

@php
$flag = $name ?? $flag;
@endphp

<flux:delegate-component :component="'flag.' . $flag">{{ $slot }}</flux:delegate-component>