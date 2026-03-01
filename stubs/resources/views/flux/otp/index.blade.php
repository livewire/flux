@blaze(fold: true)

@props([
    'length' => null,
    'private' => false,
    'toggle' => false,
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
        <?php if($toggle && $private): ?>
            x-data="{ __private: true }"
            x-effect="$el.querySelectorAll('input[data-flux-control]').forEach(i => i.type = __private ? 'password' : 'text')"
        <?php endif; ?>
    >
        <?php if($slot->isEmpty() && $length): ?>
            <?php for($i = 0; $i < $length; $i++): ?>
                <flux:otp.input />
            <?php endfor; ?>
        <?php else: ?>
            {{ $slot }}
        <?php endif; ?>

        <?php if($toggle && $private): ?>
            <button type="button" x-on:click="__private = !__private" class="flex items-center justify-center size-8 rounded-md text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors" aria-label="{{ __('Toggle visibility') }}">
                <flux:icon x-show="__private" name="eye" variant="micro" />
                <flux:icon x-show="!__private" name="eye-slash" variant="micro" x-cloak />
            </button>
        <?php endif; ?>
    </ui-otp>
</flux:with-field>
