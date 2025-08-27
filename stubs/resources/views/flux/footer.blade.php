@pure

@php
$classes = Flux::classes('[grid-area:footer]')
    ->add($attributes->has('container') ? '' : 'p-6 lg:p-8')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-flux-footer>
    <flux:with-container :attributes="$attributes->except('class')->class('p-6 lg:p-8')">
        {{ $slot }}
    </flux:with-container>
</div>
