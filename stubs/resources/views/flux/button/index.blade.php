@props([
    'iconTrailing' => null,
    'variant' => 'outline',
    'iconVariant' => null,
    'iconLeading' => null,
    'type' => 'button',
    'size' => 'base',
    'square' => null,
    'inset' => null,
    'icon' => null,
    'kbd' => null,
])

@php
$iconLeading = $icon ??= $iconLeading;

// Button should be a square if it has no text contents...
$square ??= empty((string) $slot);

// Size-up icons in square/icon-only buttons... (xs buttons just get micro size/style...)
$iconVariant ??= ($size === 'xs')
    ? ($square ? 'micro' : 'micro')
    : ($square ? 'mini' : 'micro');

$classes = Flux::classes()
    ->add('inline-flex items-center font-medium justify-center gap-2 whitespace-nowrap')
    ->add('disabled:opacity-50 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none')
    ->add(match ($size) { // Size...
        'base' => 'h-10 text-sm rounded-lg' . ' ' . ($square ? 'w-10' : 'px-4'),
        'sm' => 'h-8 text-sm rounded-md' . ' ' . ($square ? 'w-8' : 'px-3'),
        'xs' => 'h-6 text-xs rounded-md' . ' ' . ($square ? 'w-6' : 'px-2'),
    })
    ->add($inset ? match ($size) { // Inset...
        'base' => $square
            ? Flux::applyInset($inset, top: '-mt-2.5', right: '-mr-2.5', bottom: '-mb-2.5', left: '-ml-2.5')
            : Flux::applyInset($inset, top: '-mt-2.5', right: '-mr-4', bottom: '-mb-3', left: '-ml-4'),
        'sm' => $square
            ? Flux::applyInset($inset, top: '-mt-1.5', right: '-mr-1.5', bottom: '-mb-1.5', left: '-ml-1.5')
            : Flux::applyInset($inset, top: '-mt-1.5', right: '-mr-3', bottom: '-mb-1.5', left: '-ml-3'),
        'xs' => $square
            ? Flux::applyInset($inset, top: '-mt-1', right: '-mr-1', bottom: '-mb-1', left: '-ml-1')
            : Flux::applyInset($inset, top: '-mt-1', right: '-mr-2', bottom: '-mb-1', left: '-ml-2'),
    } : '')
    ->add(match ($variant) { // Background color...
        'primary' => 'bg-zinc-800 hover:bg-zinc-900 dark:bg-white dark:hover:bg-zinc-100',
        'filled' => 'bg-zinc-800/5 hover:bg-zinc-800/10 dark:bg-white/10 dark:hover:bg-white/20',
        'outline' => 'bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75',
        'danger' => 'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500',
        'ghost' => 'bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15',
        'subtle' => 'bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15',
    })
    ->add(match ($variant) { // Text color...
        'primary' => 'text-white dark:text-zinc-800',
        'filled' => 'text-zinc-800 dark:text-white',
        'outline' => 'text-zinc-800 dark:text-white',
        'danger' => 'text-white',
        'ghost' => 'text-zinc-800 dark:text-white',
        'subtle' => 'text-zinc-400 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white',
    })
    ->add(match ($variant) { // Border color...
        'outline' => 'border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600',
         default => '',
    })
    ->add(match ($variant) { // Shadows...
        'primary' => 'shadow-[inset_0px_1px_theme(colors.zinc.900),inset_0px_2px_theme(colors.white/.15)] dark:shadow-none',
        'danger' => 'shadow-[inset_0px_1px_theme(colors.red.500),inset_0px_2px_theme(colors.white/.15)] dark:shadow-none',
        'outline' => match ($size) {
            'base' => 'shadow-sm',
            'sm' => 'shadow-sm',
            'xs' => 'shadow-none',
        },
        default => '',
    })
    ->add(match ($variant) { // Grouped border treatments...
        'outline' => 'group-[]/button:-ml-[1px] group-[]/button:first:ml-0',
        'ghost' => '',
        'subtle' => '',
        default => 'group-[]/button:border-r group-[]/button:last:border-r-0 group-[]/button:border-black group-[]/button:dark:border-zinc-900/25',
    })
    ;
@endphp

<flux:with-tooltip :$attributes>
    <flux:button-or-link :$type :attributes="$attributes->class($classes)" data-flux-button>
        <?php if (is_string($iconLeading)): ?>
            <flux:icon :icon="$iconLeading" :variant="$iconVariant" />
        <?php elseif ($iconLeading): ?>
            {{ $iconLeading }}
        <?php endif; ?>

        {{ $slot }}

        <?php if ($kbd): ?>
            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $kbd }}</div>
        <?php endif; ?>

        <?php if (is_string($iconTrailing)): ?>
            <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$square ? '' : '-ml-1'" />
        <?php elseif ($iconTrailing): ?>
            {{ $iconTrailing }}
        <?php endif; ?>
    </flux:button-or-link>
</flux:with-tooltip>
