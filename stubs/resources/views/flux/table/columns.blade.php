@blaze

@props([
    'sticky' => false,
])

@php
    $classes = Flux::classes()
        ->add($sticky ? 'sticky top-0 z-20' : '')
    ;
@endphp

<thead {{ $attributes->class($classes) }} data-flux-columns>
    <tr {{ isset($tr) ? $tr->attributes : '' }}>
        {{ $tr ?? $slot }}
    </tr>
</thead>
