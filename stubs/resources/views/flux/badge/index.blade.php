@props([
    'iconVariant' => 'micro',
    'iconTrailing' => null,
    'variant' => null,
    'color' => null,
    'inset' => null,
    'size' => null,
    'icon' => null,
])

@php
$insetClasses = Flux::applyInset($inset, top: '-mt-1', right: '-mr-2', bottom: '-mb-1', left: '-ml-1');

// When using the outline icon variant, we need to size it down to match the default icon sizes...
$iconClasses = Flux::classes()->add($iconVariant === 'outline' ? 'size-4' : '');

$classes = Flux::classes()
    ->add('inline-flex items-center font-medium whitespace-nowrap')
    ->add($insetClasses)
    ->add('[print-color-adjust:exact]')
    ->add(match ($size) {
        'lg' => 'text-sm py-1.5 **:data-flux-badge-icon:mr-2',
        default => 'text-sm py-1 **:data-flux-badge-icon:mr-1.5',
        'sm' => 'text-xs py-1 **:data-flux-badge-icon:size-3 **:data-flux-badge-icon:mr-1',
    })
    ->add(match ($variant) {
        'pill' => 'rounded-full px-3',
        default => 'rounded-md px-2',
    })
    /**
     * We can't compile classes for each color because of variants color to color and Tailwind's JIT compiler.
     * We instead need to write out each one by hand. Sorry...
     */
    ->add($variant === 'solid' ? match ($color) {
        default => 'text-white dark:text-white bg-zinc-600 dark:bg-zinc-600 [&:is(button)]:hover:bg-zinc-700 dark:[button]:hover:bg-zinc-500',
        'red' => 'text-white dark:text-white bg-red-500 dark:bg-red-600 [&:is(button)]:hover:bg-red-600 dark:[button]:hover:bg-red-500',
        'orange' => 'text-white dark:text-white bg-orange-500 dark:bg-orange-600 [&:is(button)]:hover:bg-orange-600 dark:[button]:hover:bg-orange-500',
        'amber' => 'text-white dark:text-zinc-950 bg-amber-500 dark:bg-amber-500 [&:is(button)]:hover:bg-amber-600 dark:[button]:hover:bg-amber-400',
        'yellow' => 'text-white dark:text-zinc-950 bg-yellow-500 dark:bg-yellow-400 [&:is(button)]:hover:bg-yellow-600 dark:[button]:hover:bg-yellow-300',
        'lime' => 'text-white dark:text-white bg-lime-500 dark:bg-lime-600 [&:is(button)]:hover:bg-lime-600 dark:[button]:hover:bg-lime-500',
        'green' => 'text-white dark:text-white bg-green-500 dark:bg-green-600 [&:is(button)]:hover:bg-green-600 dark:[button]:hover:bg-green-500',
        'emerald' => 'text-white dark:text-white bg-emerald-500 dark:bg-emerald-600 [&:is(button)]:hover:bg-emerald-600 dark:[button]:hover:bg-emerald-500',
        'teal' => 'text-white dark:text-white bg-teal-500 dark:bg-teal-600 [&:is(button)]:hover:bg-teal-600 dark:[button]:hover:bg-teal-500',
        'cyan' => 'text-white dark:text-white bg-cyan-500 dark:bg-cyan-600 [&:is(button)]:hover:bg-cyan-600 dark:[button]:hover:bg-cyan-500',
        'sky' => 'text-white dark:text-white bg-sky-500 dark:bg-sky-600 [&:is(button)]:hover:bg-sky-600 dark:[button]:hover:bg-sky-500',
        'blue' => 'text-white dark:text-white bg-blue-500 dark:bg-blue-600 [&:is(button)]:hover:bg-blue-600 dark:[button]:hover:bg-blue-500',
        'indigo' => 'text-white dark:text-white bg-indigo-500 dark:bg-indigo-600 [&:is(button)]:hover:bg-indigo-600 dark:[button]:hover:bg-indigo-500',
        'violet' => 'text-white dark:text-white bg-violet-500 dark:bg-violet-600 [&:is(button)]:hover:bg-violet-600 dark:[button]:hover:bg-violet-500',
        'purple' => 'text-white dark:text-white bg-purple-500 dark:bg-purple-600 [&:is(button)]:hover:bg-purple-600 dark:[button]:hover:bg-purple-500',
        'fuchsia' => 'text-white dark:text-white bg-fuchsia-500 dark:bg-fuchsia-600 [&:is(button)]:hover:bg-fuchsia-600 dark:[button]:hover:bg-fuchsia-500',
        'pink' => 'text-white dark:text-white bg-pink-500 dark:bg-pink-600 [&:is(button)]:hover:bg-pink-600 dark:[button]:hover:bg-pink-500',
        'rose' => 'text-white dark:text-white bg-rose-500 dark:bg-rose-600 [&:is(button)]:hover:bg-rose-600 dark:[button]:hover:bg-rose-500',
    } :  match ($color) {
        default => 'text-zinc-700 [&_button]:text-zinc-700! dark:text-zinc-200 dark:[&_button]:text-zinc-200! bg-zinc-400/15 dark:bg-zinc-400/40 [&:is(button)]:hover:bg-zinc-400/25 dark:[button]:hover:bg-zinc-400/50',
        'red' => 'text-red-700 [&_button]:text-red-700! dark:text-red-200 dark:[&_button]:text-red-200! bg-red-400/20 dark:bg-red-400/40 [&:is(button)]:hover:bg-red-400/30 dark:[button]:hover:bg-red-400/50',
        'orange' => 'text-orange-700 [&_button]:text-orange-700! dark:text-orange-200 dark:[&_button]:text-orange-200! bg-orange-400/20 dark:bg-orange-400/40 [&:is(button)]:hover:bg-orange-400/30 dark:[button]:hover:bg-orange-400/50',
        'amber' => 'text-amber-700 [&_button]:text-amber-700! dark:text-amber-200 dark:[&_button]:text-amber-200! bg-amber-400/25 dark:bg-amber-400/40 [&:is(button)]:hover:bg-amber-400/40 dark:[button]:hover:bg-amber-400/50',
        'yellow' => 'text-yellow-800 [&_button]:text-yellow-800! dark:text-yellow-200 dark:[&_button]:text-yellow-200! bg-yellow-400/25 dark:bg-yellow-400/40 [&:is(button)]:hover:bg-yellow-400/40 dark:[button]:hover:bg-yellow-400/50',
        'lime' => 'text-lime-800 [&_button]:text-lime-800! dark:text-lime-200 dark:[&_button]:text-lime-200! bg-lime-400/25 dark:bg-lime-400/40 [&:is(button)]:hover:bg-lime-400/35 dark:[button]:hover:bg-lime-400/50',
        'green' => 'text-green-800 [&_button]:text-green-800! dark:text-green-200 dark:[&_button]:text-green-200! bg-green-400/20 dark:bg-green-400/40 [&:is(button)]:hover:bg-green-400/30 dark:[button]:hover:bg-green-400/50',
        'emerald' => 'text-emerald-800 [&_button]:text-emerald-800! dark:text-emerald-200 dark:[&_button]:text-emerald-200! bg-emerald-400/20 dark:bg-emerald-400/40 [&:is(button)]:hover:bg-emerald-400/30 dark:[button]:hover:bg-emerald-400/50',
        'teal' => 'text-teal-800 [&_button]:text-teal-800! dark:text-teal-200 dark:[&_button]:text-teal-200! bg-teal-400/20 dark:bg-teal-400/40 [&:is(button)]:hover:bg-teal-400/30 dark:[button]:hover:bg-teal-400/50',
        'cyan' => 'text-cyan-800 [&_button]:text-cyan-800! dark:text-cyan-200 dark:[&_button]:text-cyan-200! bg-cyan-400/20 dark:bg-cyan-400/40 [&:is(button)]:hover:bg-cyan-400/30 dark:[button]:hover:bg-cyan-400/50',
        'sky' => 'text-sky-800 [&_button]:text-sky-800! dark:text-sky-200 dark:[&_button]:text-sky-200! bg-sky-400/20 dark:bg-sky-400/40 [&:is(button)]:hover:bg-sky-400/30 dark:[button]:hover:bg-sky-400/50',
        'blue' => 'text-blue-800 [&_button]:text-blue-800! dark:text-blue-200 dark:[&_button]:text-blue-200! bg-blue-400/20 dark:bg-blue-400/40 [&:is(button)]:hover:bg-blue-400/30 dark:[button]:hover:bg-blue-400/50',
        'indigo' => 'text-indigo-700 [&_button]:text-indigo-700! dark:text-indigo-200 dark:[&_button]:text-indigo-200! bg-indigo-400/20 dark:bg-indigo-400/40 [&:is(button)]:hover:bg-indigo-400/30 dark:[button]:hover:bg-indigo-400/50',
        'violet' => 'text-violet-700 [&_button]:text-violet-700! dark:text-violet-200 dark:[&_button]:text-violet-200! bg-violet-400/20 dark:bg-violet-400/40 [&:is(button)]:hover:bg-violet-400/30 dark:[button]:hover:bg-violet-400/50',
        'purple' => 'text-purple-700 [&_button]:text-purple-700! dark:text-purple-200 dark:[&_button]:text-purple-200! bg-purple-400/20 dark:bg-purple-400/40 [&:is(button)]:hover:bg-purple-400/30 dark:[button]:hover:bg-purple-400/50',
        'fuchsia' => 'text-fuchsia-700 [&_button]:text-fuchsia-700! dark:text-fuchsia-200 dark:[&_button]:text-fuchsia-200! bg-fuchsia-400/20 dark:bg-fuchsia-400/40 [&:is(button)]:hover:bg-fuchsia-400/30 dark:[button]:hover:bg-fuchsia-400/50',
        'pink' => 'text-pink-700 [&_button]:text-pink-700! dark:text-pink-200 dark:[&_button]:text-pink-200! bg-pink-400/20 dark:bg-pink-400/40 [&:is(button)]:hover:bg-pink-400/30 dark:[button]:hover:bg-pink-400/50',
        'rose' => 'text-rose-700 [&_button]:text-rose-700! dark:text-rose-200 dark:[&_button]:text-rose-200! bg-rose-400/20 dark:bg-rose-400/40 [&:is(button)]:hover:bg-rose-400/30 dark:[button]:hover:bg-rose-400/50',
    });
@endphp

<flux:button-or-div :attributes="$attributes->class($classes)" data-flux-badge>
    <?php if (is_string($icon) && $icon !== ''): ?>
        <flux:icon :$icon :variant="$iconVariant" :class="$iconClasses" data-flux-badge-icon />
    <?php else: ?>
        {{ $icon }}
    <?php endif; ?>

    {{ $slot }}

    <?php if ($iconTrailing): ?>
        <div class="pl-1 flex items-center" data-flux-badge-icon-trailing>
            <?php if (is_string($iconTrailing)): ?>
                <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconClasses" />
            <?php else: ?>
                {{ $iconTrailing }}
            <?php endif; ?>
        </div>
    <?php endif; ?>
</flux:button-or-div>
