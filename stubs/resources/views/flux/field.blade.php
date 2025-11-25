@blaze

@props([
    'variant' => 'block',
])

@php
$classes = Flux::classes()
    ->add('min-w-0') // This is here to allow nested input elements like flux::input.file to truncate properly...
    ->add('[&:not(:has([data-flux-field])):has([data-flux-control][disabled])>[data-flux-label]]:opacity-50') // Dim labels for fields with no nested fields when a control is disabled...
    ->add('[&:has(>[data-flux-radio-group][disabled])>[data-flux-label]]:opacity-50') // Special case for radio groups because they are nested fields...
    ->add('[&:has(>[data-flux-checkbox-group][disabled])>[data-flux-label]]:opacity-50') // Special case for checkbox groups because they are nested fields...
    ->add(match ($variant) {
        default => 'block',
        'inline' => [
            'grid gap-x-3 gap-y-1.5',
            // Support for inline controls...
            'has-[[data-flux-label]~[data-flux-control]]:grid-cols-[1fr_auto]',
            'has-[[data-flux-control]~[data-flux-label]]:grid-cols-[auto_1fr]',
            '[&>[data-flux-control]~[data-flux-description]]:row-start-2 [&>[data-flux-control]~[data-flux-description]]:col-start-2',
            '[&>[data-flux-control]~[data-flux-error]]:col-span-2 [&>[data-flux-control]~[data-flux-error]]:mt-1', // Position error messages...
            '[&>[data-flux-label]~[data-flux-control]]:row-start-1 [&>[data-flux-label]~[data-flux-control]]:col-start-2',
            // Support for inline inputs...
            'has-[[data-flux-label]~[data-flux-input]]:grid-cols-[auto_1fr]',
            'has-[[data-flux-input]~[data-flux-label]]:grid-cols-[1fr_auto]',
            '[&>[data-flux-input]~[data-flux-description]]:row-start-2 [&>[data-flux-input]~[data-flux-description]]:col-start-2',
            '[&>[data-flux-input]~[data-flux-error]]:col-span-2 [&>[data-flux-input]~[data-flux-error]]:mt-1', // Position error messages...
            '[&>[data-flux-label]~[data-flux-input]]:row-start-1 [&>[data-flux-label]~[data-flux-input]]:col-start-2',
        ],
    })
    ->add(match ($variant) {
        default => [ // Adjust spacing around label...
            '*:data-flux-label:mb-3 [&>[data-flux-label]:has(+[data-flux-description])]:mb-2',
        ],
        'inline' => '',
    })
    ->add(match ($variant) {
        default => [ // Adjust spacing around description...
            '[&>[data-flux-label]+[data-flux-description]]:mt-0',
            '[&>[data-flux-label]+[data-flux-description]]:mb-3',
            '[&>*:not([data-flux-label])+[data-flux-description]]:mt-3',
        ],
        'inline' => '',
    });
@endphp

<ui-field {{ $attributes->class($classes) }} data-flux-field>
    {{ $slot }}
</ui-field>
