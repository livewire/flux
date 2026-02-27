@blaze(fold: true)

@props([
    'color' => null,
])

@php
$trackClasses = Flux::classes()
    ->add('h-1.5 relative w-full overflow-hidden bg-zinc-200 dark:bg-white/10')
    ->add('[print-color-adjust:exact]')
    ->add('rounded-full')
    ;

$barClasses = Flux::classes()
    ->add('h-full rounded-full transition-[width] duration-300 ease-out')
    ->add(match ($color) {
        'red'     => 'bg-red-600 dark:bg-red-400',
        'orange'  => 'bg-orange-600 dark:bg-orange-400',
        'amber'   => 'bg-amber-600 dark:bg-amber-400',
        'yellow'  => 'bg-yellow-600 dark:bg-yellow-400',
        'lime'    => 'bg-lime-600 dark:bg-lime-400',
        'green'   => 'bg-green-600 dark:bg-green-400',
        'emerald' => 'bg-emerald-600 dark:bg-emerald-400',
        'teal'    => 'bg-teal-600 dark:bg-teal-400',
        'cyan'    => 'bg-cyan-600 dark:bg-cyan-400',
        'sky'     => 'bg-sky-600 dark:bg-sky-400',
        'blue'    => 'bg-blue-600 dark:bg-blue-400',
        'indigo'  => 'bg-indigo-600 dark:bg-indigo-400',
        'violet'  => 'bg-violet-600 dark:bg-violet-400',
        'purple'  => 'bg-purple-600 dark:bg-purple-400',
        'fuchsia' => 'bg-fuchsia-600 dark:bg-fuchsia-400',
        'pink'    => 'bg-pink-600 dark:bg-pink-400',
        'rose'    => 'bg-rose-600 dark:bg-rose-400',
        default   => 'bg-accent',
    })
    ;
@endphp

<ui-progress {{ $attributes->class($trackClasses) }} data-flux-progress>
    <div class="{{ $barClasses }}" style="width: var(--flux-progress-percentage)"></div>
</ui-progress>
