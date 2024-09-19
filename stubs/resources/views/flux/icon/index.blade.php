{{-- Credit: Heroicons (https://heroicons.com) --}}

@props([
    'icon' => null,
    'name' => null,
])

@php
$icon = $name ?? $icon;
@endphp

<x-dynamic-component :component="'flux::icon.' . $icon" :$attributes />
