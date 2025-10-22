@blaze

@php
extract(Flux::forwardedAttributes($attributes, [
    'name',
    'multiple',
    'size',
]));
@endphp

@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'multiple' => null,
    'size' => null,
])

@php
$classes = Flux::classes()
    ->add('w-full flex items-center gap-4')
    ->add('[[data-flux-input-group]_&]:items-stretch [[data-flux-input-group]_&]:gap-0')

    // NOTE: We need to add relative positioning here to prevent odd overflow behaviors because of
    // "sr-only": https://github.com/tailwindlabs/tailwindcss/discussions/12429
    ->add('relative')
    ;

[ $styleAttributes, $attributes ] = Flux::splitAttributes($attributes);
@endphp

<div
    {{ $styleAttributes->class($classes) }}
    data-flux-input-file
    wire:ignore
    tabindex="0"
    x-data {{-- This is here to "scope" the x-ref references inside this component from interfering with others outside... --}}
    x-on:click.prevent.stop="$refs.input.click()"
    x-on:keydown.enter.prevent.stop="$refs.input.click()"
    x-on:keydown.space.prevent.stop
    x-on:keyup.space.prevent.stop="$refs.input.click()"
    x-on:change="$refs.name.textContent = $event.target.files[1] ? ($event.target.files.length + ' {!! __('files') !!}') : ($event.target.files[0]?.name || '{!! __('No file chosen') !!}')"
>
    <input
        x-ref="input"
        x-on:click.stop {{-- Without this, the parent element's click listener will ".prevent" the file input from being clicked... --}}
        {{-- This is here because clearing the input via .value = "" doesn't trigger a change event... --}}
        {{-- We need it to so that we can know to clear the selected file labels when the input is cleared... --}}
        x-init="Object.defineProperty($el, 'value', {
          ...Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value'),
            set(value) {
            Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value').set.call(this, value);

            if(! value) this.dispatchEvent(new Event('change', { bubbles: true }))
          }
        })"
        type="file"
        class="sr-only"
        tabindex="-1"
        {{ $attributes }} {{ $multiple ? 'multiple' : '' }} @if($name)name="{{ $name }}"@endif
    >

    <flux:button as="div" class="cursor-pointer" :$size aria-hidden="true">
        <?php if ($multiple) : ?>
            {!! __('Choose files') !!}
        <?php else : ?>
            {!! __('Choose file') !!}
        <?php endif; ?>
    </flux:button>

    <div
        x-ref="name"
        @class([
            'cursor-default select-none truncate whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400 font-medium',
            '[[data-flux-input-group]_&]:flex-1 [[data-flux-input-group]_&]:border-e [[data-flux-input-group]_&]:border-y [[data-flux-input-group]_&]:shadow-xs [[data-flux-input-group]_&]:border-zinc-200 dark:[[data-flux-input-group]_&]:border-zinc-600 [[data-flux-input-group]_&]:px-4 [[data-flux-input-group]_&]:bg-white dark:[[data-flux-input-group]_&]:bg-zinc-700 [[data-flux-input-group]_&]:flex [[data-flux-input-group]_&]:items-center dark:[[data-flux-input-group]_&]:text-zinc-300',
        ])
        aria-hidden="true"
    >
        {!! __('No file chosen') !!}
    </div>
</div>
