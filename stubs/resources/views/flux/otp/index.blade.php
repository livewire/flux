@props([
    'length' => null,
    'private' => false,
])

@php
    $classes = Flux::classes()
        ->add('flex items-center gap-2 isolate w-fit')
        ->add('[&_[data-flux-input-group]]:w-auto')
@endphp

<flux:with-field :$attributes>
    <ui-otp
        {{ $attributes->class($classes) }}
        data-flux-otp
        data-flux-control
        role="group"
        data-flux-input-aria-label="{{ __('Character {current} of {total}') }}"
    >
        <?php if($slot->isEmpty() && $length): ?>
            <?php for($i = 0; $i < $length; $i++): ?>
                <flux:otp.input />
            <?php endfor; ?>
        <?php else: ?>
            {{ $slot }}
        <?php endif; ?>
    </ui-otp>
</flux:with-field>