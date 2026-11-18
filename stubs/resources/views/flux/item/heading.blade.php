@blaze(fold: true)

@props([
    'size' => 'base',
    'accent' => false,
    'level' => null,
])

@php
$attributes = $attributes->merge([
    // Long words and addresses wrap rather than run under the actions...
    'class' => 'col-start-2 row-start-2 min-w-0 break-words',
    'data-flux-item-heading' => '',
]);
@endphp

<flux:heading :$attributes :$size :$accent :$level>
    {{ $slot }}
</flux:heading>
