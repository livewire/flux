@blaze(fold: true, unsafe: [
    'icon:class',
    'tooltip:position', 'tooltip:kbd', 'tooltip',
])

@props([
    'variant' => 'outline',
    'checked' => null,
    'size' => 'base',
    'name' => null,
    'icon' => null,
    'color' => null,
])

@php
// We only want to show the name attribute if it has been set manually,
// but not if it has been inferred from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

// Toggle should be square if it has no text contents...
$square = $slot->isEmpty();

$iconClasses = Flux::classes()
    ->add($square && $size !== 'xs' ? 'size-5' : 'size-4')
    ->add($attributes->pluck('icon:class'))
    ;

$classes = Flux::classes()
    ->add('group relative inline-flex items-center font-medium justify-center gap-2 whitespace-nowrap outline-offset-2')
    ->add('transition select-none touch-manipulation')
    ->add('[&[disabled]]:opacity-75 dark:[&[disabled]]:opacity-75 [&[disabled]]:cursor-default')
    ->add(match ($size) {
        'base' => 'h-10 text-sm rounded-lg' . ' ' . ($square ? 'w-10' : ($icon ? 'ps-3 pe-4' : 'px-4')),
        'sm' => 'h-8 text-sm rounded-md' . ' ' . ($square ? 'w-8' : 'px-3'),
        'xs' => 'h-6 text-xs rounded-md' . ' ' . ($square ? 'w-6' : 'px-2'),
    })
    ->add(match ($variant) {
        'filled' => 'bg-zinc-800/5 hover:bg-zinc-800/10 dark:bg-white/10 dark:hover:bg-white/20',
        'outline' => 'bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75',
        'ghost' => 'bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15',
        'subtle' => 'bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15',
    })
    ->add(match ($variant) {
        'subtle' => 'text-zinc-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-white',
        default => 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white',
    })
    ->add('data-checked:text-(--color-accent-content) data-checked:hover:text-(--color-accent-content) dark:data-checked:text-(--color-accent-content) dark:data-checked:hover:text-(--color-accent-content)')
    ->add(match ($variant) {
        'outline' => 'border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600',
        default => '',
    })
    ->add(match ($variant) {
        'outline' => match ($size) {
            'base', 'sm' => 'shadow-xs',
            'xs' => 'shadow-none',
        },
        default => '',
    })
    ;
@endphp

<flux:accent :$color class="contents">
    <flux:with-tooltip :$attributes>
        <ui-switch {{ $attributes->class($classes) }} @if($showName) name="{{ $name }}" @endif @if($checked) checked data-checked @endif data-flux-control data-flux-toggle>
            <?php if (is_string($icon) && $icon !== ''): ?>
                <span class="grid place-items-center">
                    <flux:icon :$icon variant="outline" :class="$iconClasses->add('col-start-1 row-start-1 group-data-checked:hidden')" />
                    <flux:icon :$icon variant="solid" :class="$iconClasses->add('col-start-1 row-start-1 hidden group-data-checked:block')" />
                </span>
            <?php elseif ($icon): ?>
                {{ $icon }}
            <?php endif; ?>

            <?php if (! $slot->isEmpty()): ?>
                <span class="text-zinc-600 dark:text-zinc-300">{{ $slot }}</span>
            <?php endif; ?>
        </ui-switch>
    </flux:with-tooltip>
</flux:accent>
