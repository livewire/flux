@blaze

@props([
    'key' => null,
    'sticky' => false,
])

@php
$classes = Flux::classes()
    ->add($sticky ? 'last:sticky last:bottom-0 last:z-20' : '')
    ;
@endphp

<tr @if ($key) wire:key="table-{{ $key }}" @endif {{ $attributes->class($classes) }} data-flux-row>
    {{ $slot }}
</tr>
