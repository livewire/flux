@pure

@props([
    'variant' => null,
    'color' => null,
])

@php
$class = Flux::classes()
    ->add('text-xs font-medium rounded-sm px-1 py-0.5')
    /**
     * We can't compile classes for each color because of variants color to color and Tailwind's JIT compiler.
     * We instead need to write out each one by hand. Sorry...
     */
    ->add($variant === 'solid' ? match ($color) {
        default => 'text-white dark:text-white bg-zinc-600 dark:bg-zinc-600',
        'red' => 'text-white dark:text-white bg-red-500 dark:bg-red-600',
        'orange' => 'text-white dark:text-white bg-orange-500 dark:bg-orange-600',
        'amber' => 'text-white dark:text-zinc-950 bg-amber-500 dark:bg-amber-500',
        'yellow' => 'text-white dark:text-zinc-950 bg-yellow-500 dark:bg-yellow-400',
        'lime' => 'text-white dark:text-white bg-lime-500 dark:bg-lime-600',
        'green' => 'text-white dark:text-white bg-green-500 dark:bg-green-600',
        'emerald' => 'text-white dark:text-white bg-emerald-500 dark:bg-emerald-600',
        'teal' => 'text-white dark:text-white bg-teal-500 dark:bg-teal-600',
        'cyan' => 'text-white dark:text-white bg-cyan-500 dark:bg-cyan-600',
        'sky' => 'text-white dark:text-white bg-sky-500 dark:bg-sky-600',
        'blue' => 'text-white dark:text-white bg-blue-500 dark:bg-blue-600',
        'indigo' => 'text-white dark:text-white bg-indigo-500 dark:bg-indigo-600',
        'violet' => 'text-white dark:text-white bg-violet-500 dark:bg-violet-600',
        'purple' => 'text-white dark:text-white bg-purple-500 dark:bg-purple-600',
        'fuchsia' => 'text-white dark:text-white bg-fuchsia-500 dark:bg-fuchsia-600',
        'pink' => 'text-white dark:text-white bg-pink-500 dark:bg-pink-600',
        'rose' => 'text-white dark:text-white bg-rose-500 dark:bg-rose-600',
    } :  match ($color) {
        default => 'text-zinc-700 dark:text-zinc-200 bg-zinc-400/15 dark:bg-zinc-400/40',
        'red' => 'text-red-700 dark:text-red-200 bg-red-400/20 dark:bg-red-400/40',
        'orange' => 'text-orange-700 dark:text-orange-200 bg-orange-400/20 dark:bg-orange-400/40',
        'amber' => 'text-amber-700 dark:text-amber-200 bg-amber-400/25 dark:bg-amber-400/40',
        'yellow' => 'text-yellow-800 dark:text-yellow-200 bg-yellow-400/25 dark:bg-yellow-400/40',
        'lime' => 'text-lime-800 dark:text-lime-200 bg-lime-400/25 dark:bg-lime-400/40',
        'green' => 'text-green-800 dark:text-green-200 bg-green-400/20 dark:bg-green-400/40',
        'emerald' => 'text-emerald-800 dark:text-emerald-200 bg-emerald-400/20 dark:bg-emerald-400/40',
        'teal' => 'text-teal-800 dark:text-teal-200 bg-teal-400/20 dark:bg-teal-400/40',
        'cyan' => 'text-cyan-800 dark:text-cyan-200 bg-cyan-400/20 dark:bg-cyan-400/40',
        'sky' => 'text-sky-800 dark:text-sky-200 bg-sky-400/20 dark:bg-sky-400/40',
        'blue' => 'text-blue-800 dark:text-blue-200 bg-blue-400/20 dark:bg-blue-400/40',
        'indigo' => 'text-indigo-700 dark:text-indigo-200 bg-indigo-400/20 dark:bg-indigo-400/40',
        'violet' => 'text-violet-700 dark:text-violet-200 bg-violet-400/20 dark:bg-violet-400/40',
        'purple' => 'text-purple-700 dark:text-purple-200 bg-purple-400/20 dark:bg-purple-400/40',
        'fuchsia' => 'text-fuchsia-700 dark:text-fuchsia-200 bg-fuchsia-400/20 dark:bg-fuchsia-400/40',
        'pink' => 'text-pink-700 dark:text-pink-200 bg-pink-400/20 dark:bg-pink-400/40',
        'rose' => 'text-rose-700 dark:text-rose-200 bg-rose-400/20 dark:bg-rose-400/40',
    });
@endphp

<span {{ $attributes->class($class) }}>{{ $slot }}</span>
