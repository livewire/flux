@php
$classes = Flux::classes()
    ->add('*:data-flux-field:mb-3')
    ->add('[&>[data-flux-field]:has(>[data-flux-description])]:mb-4')
    ->add('[&>[data-flux-field]:last-child]:mb-0!')
    ;
@endphp

<flux:with-field :$attributes>
    <ui-checkbox-group {{ $attributes->class($classes) }} data-flux-checkbox-group>
        {{ $slot }}
    </ui-checkbox-group>
</flux:with-field>
