@blaze

@props([
    'legend' => null,
    'description' => null,
])

@php
$classes = Flux::classes()
    ->add('[&[disabled]_[data-flux-label]]:opacity-50') // Dim labels when the fieldset is disabled...
    ->add('[&[disabled]_[data-flux-legend]]:opacity-50') // Dim legend when the fieldset is disabled...

    // Adjust spacing between fields...
    ->add('*:data-flux-field:mb-3')

    // Adjust spacing between fields...
    ->add('*:data-flux-field:mb-3')
    ->add('[&>[data-flux-field]:has(>[data-flux-description])]:mb-4')
    ->add('[&>[data-flux-field]:last-child]:mb-0!')

    // Adjust spacing below legend...
    ->add('[&>[data-flux-legend]]:mb-4')
    ->add('[&>[data-flux-legend]:has(+[data-flux-description])]:mb-2')

    // Adjust spacing below description...
    ->add('[&>[data-flux-legend]+[data-flux-description]]:mb-4')
    ;
@endphp

<fieldset {{ $attributes->class($classes) }} data-flux-fieldset>
    <?php if ($legend): ?>
        <flux:legend>{{ $legend }}</flux:legend>
    <?php endif; ?>

    <?php if ($description): ?>
        <flux:description>{{ $description }}</flux:description>
    <?php endif; ?>

    {{ $slot }}
</fieldset>
