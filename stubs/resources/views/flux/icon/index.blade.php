{{-- Credit: Heroicons (https://heroicons.com) --}}
{{-- Credit: Blade-Ui-Kit (https://blade-ui-kit.com/) --}}

@props([
    'icon' => null,
    'name' => null,
    'variant' => 'outline',
    'classes' => null,
])

@php
    $icon = $name ?? $icon;
    $classes = Flux::classes('shrink-0')
        ->add(match($variant) {
            'outline' => '[:where(&)]:size-6',
            'solid' => '[:where(&)]:size-6',
            'mini' => '[:where(&)]:size-5',
            'micro' => '[:where(&)]:size-4',
        });
@endphp

<x-dynamic-component :component="str_starts_with($icon,'buk::') ? str_replace('buk::', '', $icon) : 'flux::icon.' . $icon"
                     :attributes="$attributes->except('classes')"
                     :class="$classes"
                     :variant="$variant"
/>
