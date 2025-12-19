@blaze

@props([
    'accent' => true,
    'size' => 'base',
    'label' => null,
    'icon' => null,
])

@php
$classes = Flux::classes()
    ->add('flex relative items-center font-medium justify-center gap-2 whitespace-nowrap')
    ->add(match ($size) {
        'base' => 'h-10 text-sm rounded-lg px-4 [&:has(>:not(span):first-child)]:ps-3 [&:has(>:not(span):last-child)]:pe-3',
        'sm' => 'h-8 text-sm rounded-md px-3',
        'xs' => 'h-6 text-xs rounded-md px-2',
    })
    ->add(match ($size) {
        'base' => 'shadow-xs',
        'sm' => 'shadow-xs',
        'xs' => 'shadow-none',
    })
    ->add('text-zinc-800 dark:text-white')
    ->add('bg-white dark:bg-zinc-700')
    ->add('after:absolute after:-inset-px after:rounded-lg')
    ->add('border border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600')
    ->add([
        '[--haze:color-mix(in_oklab,_var(--color-accent-content),_transparent_97.5%)]',
        '[--haze-border:color-mix(in_oklab,_var(--color-accent-content),_transparent_80%)]',
        '[--haze-light:color-mix(in_oklab,_var(--color-accent),_transparent_98%)]',
        'dark:[--haze:color-mix(in_oklab,_var(--color-accent-content),_transparent_90%)]',
    ])
    ->add(match ($accent) {
        true => [
            'hover:border-[var(--haze-border)] dark:hover:border-zinc-500',
            'dark:data-checked:bg-white/15 data-checked:border-(--color-accent) hover:data-checked:border-(--color-accent)',
            'hover:after:bg-[var(--haze-light)] dark:hover:after:bg-white/[4%] data-checked:after:bg-(--haze) hover:data-checked:after:bg-(--haze)',
        ],
        false => [
            'hover:border-zinc-200 dark:hover:border-zinc-500',
            'data-checked:bg-zinc-50 dark:data-checked:bg-white/15 data-checked:border-zinc-800 dark:data-checked:border-white',
            'hover:bg-zinc-50 dark:hover:bg-zinc-600/75',
        ],
    })
    ->add('disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none')
    ;

$iconAttributes = Flux::attributesAfter('icon:', $attributes, [
    'class' => 'text-zinc-300 dark:text-zinc-400 in-data-checked:text-zinc-800 dark:in-data-checked:text-white',
    'variant' => 'micro',
]);
@endphp

{{-- We have to put tabindex="-1" here because otherwise, Livewire requests will wipe out tabindex state, --}}
{{-- even with durable attributes for some reason... --}}
{{-- We have to put "data-flux-field" so that a single box can be disabled without "disabling" the group field label... --}}
<ui-radio {{ $attributes->class($classes) }} data-flux-control data-flux-radio-buttons tabindex="-1" data-flux-field>
    <?php if (is_string($icon) && $icon !== ''): ?>
        <flux:icon :icon="$icon" :attributes="$iconAttributes" />
    <?php elseif ($icon): ?>
        {{ $icon }}
    <?php endif; ?>

    @if (isset($label) || $slot->isNotEmpty())
        <span>{{ $label ?? $slot }}</span>
    @endif
</ui-radio>
