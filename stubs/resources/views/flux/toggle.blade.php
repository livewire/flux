@blaze(fold: true, unsafe: [
    'icon:class', 'icon:variant', 'on:icon', 'off:icon', 'on:label', 'off:label',
    'tooltip:position', 'tooltip:kbd', 'tooltip',
])

@php $onLabel ??= $attributes->pluck('on:label'); @endphp
@php $offLabel ??= $attributes->pluck('off:label'); @endphp
@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp
@php $onIcon ??= $attributes->pluck('on:icon'); @endphp
@php $offIcon ??= $attributes->pluck('off:icon'); @endphp

@props([
    'variant' => 'outline',
    'checked' => null,
    'size' => 'base',
    'name' => null,
    'icon' => null,
    'iconVariant' => 'solid',
    'label' => null,
    'color' => null,
    'inset' => null,
    'onLabel' => null,
    'offLabel' => null,
    'onIcon' => null,
    'offIcon' => null,
])

@php
// We only want to show the name attribute if it has been set manually,
// but not if it has been inferred from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$onIcon = is_string($onIcon) && $onIcon !== '' ? $onIcon : null;
$offIcon = is_string($offIcon) && $offIcon !== '' ? $offIcon : null;

$square = $slot->isEmpty() && ! $onLabel && ! $label;
$hasIcon = $icon || $onIcon;

$iconClasses = Flux::classes()
    ->add(match ($variant) {
        'outline' => 'text-zinc-500/85 dark:text-zinc-300/80 in-data-checked:text-(--color-accent-content) dark:in-data-checked:text-(--color-accent-content)',
        'filled' => 'text-zinc-500/85 dark:text-zinc-300/80 in-data-checked:text-(--color-accent-content) dark:in-data-checked:text-(--color-accent-content)',
        'ghost' => 'text-zinc-500/85 dark:text-zinc-300/80 in-data-checked:text-(--color-accent-content) dark:in-data-checked:text-(--color-accent-content)',
        'subtle' => join(' ', [
            'text-zinc-400/90 group-hover:text-zinc-500 in-data-checked:text-zinc-500 in-data-checked:group-hover:text-zinc-800',
            'dark:text-zinc-500/90 dark:group-hover:text-zinc-400 dark:in-data-checked:text-zinc-400 dark:in-data-checked:group-hover:text-white',
        ])
    })
    ->add($square && $size !== 'xs' ? 'size-5' : 'size-4')
    ->add($attributes->pluck('icon:class'))
    ;

$classes = Flux::classes()
    ->add('group relative inline-flex items-center font-medium justify-center whitespace-nowrap outline-offset-2')
    ->add('transition touch-manipulation')
    ->add('[&[disabled]]:opacity-50 dark:[&[disabled]]:opacity-50 [&[disabled]]:shadow-none [&[disabled]]:cursor-default [&[disabled]]:pointer-events-none')
    ->add(match ($size) {
        'base' => 'h-10 text-sm rounded-lg gap-2' . ' ' . ($square ? 'w-10' : ($hasIcon ? 'ps-3 pe-4' : 'px-4')),
        'sm' => 'h-8 text-sm rounded-md gap-2' . ' ' . ($square ? 'w-8' : ($hasIcon ? 'ps-2 pe-3' : 'px-3')),
        'xs' => 'h-6 text-xs rounded-md gap-1' . ' ' . ($square ? 'w-6' : ($hasIcon ? 'ps-1 pe-2' : 'px-2')),
    })
    ->add($inset ? match ($size) {
        'base' => $square
            ? Flux::applyInset($inset, top: '-mt-2.5', right: '-me-2.5', bottom: '-mb-2.5', left: '-ms-2.5')
            : Flux::applyInset($inset, top: '-mt-2.5', right: '-me-4', bottom: '-mb-3', left: ($hasIcon ? '-ms-3' : '-ms-4')),
        'sm' => $square
            ? Flux::applyInset($inset, top: '-mt-1.5', right: '-me-1.5', bottom: '-mb-1.5', left: '-ms-1.5')
            : Flux::applyInset($inset, top: '-mt-1.5', right: '-me-3', bottom: '-mb-1.5', left: ($hasIcon ? '-ms-2' : '-ms-3')),
        'xs' => $square
            ? Flux::applyInset($inset, top: '-mt-1', right: '-me-1', bottom: '-mb-1', left: '-ms-1')
            : Flux::applyInset($inset, top: '-mt-1', right: '-me-2', bottom: '-mb-1', left: ($hasIcon ? '-ms-1' : '-ms-2')),
    } : '')
    ->add(match ($variant) {
        'outline' => 'bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75',
        'filled' => 'bg-zinc-800/5 hover:bg-zinc-800/10 dark:bg-white/10 dark:hover:bg-white/20',
        'ghost' => 'bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15',
        'subtle' => 'bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15',
    })
    ->add(match ($variant) { // Text color...
        'outline' => 'text-zinc-600/85 data-checked:text-zinc-800 dark:text-zinc-300/95 dark:data-checked:text-white',
        'filled' => 'text-zinc-600/85 data-checked:text-zinc-800 dark:text-zinc-300/95 dark:data-checked:text-white',
        'ghost' => 'text-zinc-600/85 data-checked:text-zinc-800 dark:text-zinc-300/95 dark:data-checked:text-white',
        'subtle' => join(' ', [
            'text-zinc-500/85 hover:text-zinc-500 data-checked:text-zinc-500 data-checked:hover:text-zinc-800',
            'dark:text-zinc-400/80 dark:hover:text-zinc-300 dark:data-checked:text-zinc-400 dark:data-checked:hover:text-white',
        ])
    })
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
            <?php if ((is_string($icon) && $icon !== '') || $onIcon): ?>
                <flux:icon :icon="$onIcon ?? $icon" :variant="$iconVariant" :class="$iconClasses->add('hidden group-data-checked:block')" />
                <flux:icon :icon="$offIcon ?? $onIcon ?? $icon" variant="outline" :class="$iconClasses->add('group-data-checked:hidden')" />
            <?php elseif ($icon): ?>
                {{ $icon }}
            <?php endif; ?>

            <?php if ($slot->isNotEmpty() || $onLabel || $label): ?>
                <?php $onLabel = $slot->isNotEmpty() ? $slot : ($onLabel ?? $label); ?>

                <span class="group-data-checked:hidden">{{ $offLabel ?? $onLabel }}</span>
                <span class="hidden group-data-checked:block">{{ $onLabel }}</span>
            <?php endif; ?>
        </ui-switch>
    </flux:with-tooltip>
</flux:accent>
