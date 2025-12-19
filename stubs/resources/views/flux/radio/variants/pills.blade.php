@blaze

@props([
    'accent' => true,
    'label' => null,
])

@php
$classes = Flux::classes()
    ->add('flex whitespace-nowrap gap-2 items-center py-1 px-2 rounded-full text-sm font-medium leading-4')
    ->add('bg-zinc-800/6 dark:bg-white/10 hover:bg-zinc-800/10 dark:hover:bg-white/15 text-zinc-800 hover:text-zinc-800 dark:text-white/70 dark:hover:text-white')
    ->add(match ($accent) {
        true => 'data-checked:bg-(--color-accent) hover:data-checked:bg-(--color-accent)',
        false => 'data-checked:bg-zinc-800 dark:data-checked:bg-white',
    })
    ->add(match ($accent) {
        true => 'data-checked:text-(--color-accent-foreground) hover:data-checked:text-(--color-accent-foreground)',
        false => 'data-checked:text-white dark:data-checked:text-zinc-800',
    })
    ->add('[&[disabled]]:opacity-50 dark:[&[disabled]]:opacity-75 [&[disabled]]:cursor-default [&[disabled]]:pointer-events-none')
    ;
@endphp

{{-- We have to put tabindex="-1" here because otherwise, Livewire requests will wipe out tabindex state, --}}
{{-- even with durable attributes for some reason... --}}
{{-- We have to put "data-flux-field" so that a single box can be disabled without "disabling" the group field label... --}}
<ui-radio {{ $attributes->class($classes) }} data-flux-control data-flux-radio-pills tabindex="-1" data-flux-field>
    {{ $label ?? $slot }}
</ui-radio>
