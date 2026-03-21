@blaze(fold: true)

@props([
    'color' => null,
])

@php
$trackClasses = Flux::classes()
    ->add('h-1.5 relative w-full overflow-hidden bg-zinc-200 dark:bg-white/10')
    ->add('[print-color-adjust:exact]')
    ->add('rounded-full')
    ->add(match ($color) {
        'red'     => '[--flux-progress-color:var(--color-red-600)] dark:[--flux-progress-color:var(--color-red-400)]',
        'orange'  => '[--flux-progress-color:var(--color-orange-600)] dark:[--flux-progress-color:var(--color-orange-400)]',
        'amber'   => '[--flux-progress-color:var(--color-amber-600)] dark:[--flux-progress-color:var(--color-amber-400)]',
        'yellow'  => '[--flux-progress-color:var(--color-yellow-600)] dark:[--flux-progress-color:var(--color-yellow-400)]',
        'lime'    => '[--flux-progress-color:var(--color-lime-600)] dark:[--flux-progress-color:var(--color-lime-400)]',
        'green'   => '[--flux-progress-color:var(--color-green-600)] dark:[--flux-progress-color:var(--color-green-400)]',
        'emerald' => '[--flux-progress-color:var(--color-emerald-600)] dark:[--flux-progress-color:var(--color-emerald-400)]',
        'teal'    => '[--flux-progress-color:var(--color-teal-600)] dark:[--flux-progress-color:var(--color-teal-400)]',
        'cyan'    => '[--flux-progress-color:var(--color-cyan-600)] dark:[--flux-progress-color:var(--color-cyan-400)]',
        'sky'     => '[--flux-progress-color:var(--color-sky-600)] dark:[--flux-progress-color:var(--color-sky-400)]',
        'blue'    => '[--flux-progress-color:var(--color-blue-600)] dark:[--flux-progress-color:var(--color-blue-400)]',
        'indigo'  => '[--flux-progress-color:var(--color-indigo-600)] dark:[--flux-progress-color:var(--color-indigo-400)]',
        'violet'  => '[--flux-progress-color:var(--color-violet-600)] dark:[--flux-progress-color:var(--color-violet-400)]',
        'purple'  => '[--flux-progress-color:var(--color-purple-600)] dark:[--flux-progress-color:var(--color-purple-400)]',
        'fuchsia' => '[--flux-progress-color:var(--color-fuchsia-600)] dark:[--flux-progress-color:var(--color-fuchsia-400)]',
        'pink'    => '[--flux-progress-color:var(--color-pink-600)] dark:[--flux-progress-color:var(--color-pink-400)]',
        'rose'    => '[--flux-progress-color:var(--color-rose-600)] dark:[--flux-progress-color:var(--color-rose-400)]',
        default   => '[--flux-progress-color:var(--color-accent)]',
    })
    ;

$barClasses = Flux::classes()
    ->add('h-full rounded-full transition-[width] duration-300 ease-out')
    ->add('bg-[var(--flux-progress-color)]')
    ;
@endphp

<ui-progress {{ $attributes->class($trackClasses) }} data-flux-progress>
    <div class="{{ $barClasses }}" style="width: var(--flux-progress-percentage)"></div>
</ui-progress>
