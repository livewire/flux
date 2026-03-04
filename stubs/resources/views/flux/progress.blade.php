@blaze(fold: true)

@props([
    'circular' => null,
    'color' => null,
    'size' => 'base',
    'label' => false,
])

<?php if ($circular): ?>
    @php
    $value = (float) ($attributes->pluck('value') ?? 0);
    $max = (float) ($attributes->pluck('max') ?? 100);
    $value = max(0, min($max, $value));
    $percentage = $max > 0 ? ($value / $max) * 100 : 0;

    $strokeWidth = match ($size) { 'xs' => 3, 'sm' => 4, 'lg' => 6, 'xl' => 8, default => 5 };
    $radius = match ($size) { 'xs' => 12, 'sm' => 20, 'lg' => 44, 'xl' => 58, default => 28 };
    $circumference = 2 * M_PI * $radius;
    $offset = $circumference - ($percentage / 100 * $circumference);
    $viewBox = ($radius + $strokeWidth) * 2;

    $circularClasses = Flux::classes()
        ->add('relative inline-flex')
        ->add(match ($size) { 'xs' => 'size-8', 'sm' => 'size-12', 'lg' => 'size-24', 'xl' => 'size-32', default => 'size-16' })
        ;

    $circularTrackClasses = Flux::classes()->add('text-zinc-200 dark:text-white/10')->add('[print-color-adjust:exact]');

    $circularBarClasses = Flux::classes()
        ->add('transition-[stroke-dashoffset] duration-300 ease-out')
        ->add(match ($color) {
            'red'     => 'text-red-600 dark:text-red-400',
            'orange'  => 'text-orange-600 dark:text-orange-400',
            'amber'   => 'text-amber-600 dark:text-amber-400',
            'yellow'  => 'text-yellow-600 dark:text-yellow-400',
            'lime'    => 'text-lime-600 dark:text-lime-400',
            'green'   => 'text-green-600 dark:text-green-400',
            'emerald' => 'text-emerald-600 dark:text-emerald-400',
            'teal'    => 'text-teal-600 dark:text-teal-400',
            'cyan'    => 'text-cyan-600 dark:text-cyan-400',
            'sky'     => 'text-sky-600 dark:text-sky-400',
            'blue'    => 'text-blue-600 dark:text-blue-400',
            'indigo'  => 'text-indigo-600 dark:text-indigo-400',
            'violet'  => 'text-violet-600 dark:text-violet-400',
            'purple'  => 'text-purple-600 dark:text-purple-400',
            'fuchsia' => 'text-fuchsia-600 dark:text-fuchsia-400',
            'pink'    => 'text-pink-600 dark:text-pink-400',
            'rose'    => 'text-rose-600 dark:text-rose-400',
            default   => 'text-accent',
        })
        ;

    $circularLabelClasses = Flux::classes()
        ->add('absolute inset-0 flex items-center justify-center')
        ->add('font-medium text-zinc-800 dark:text-white')
        ->add(match ($size) { 'xs' => 'text-[0.5rem]', 'sm' => 'text-[0.625rem]', 'lg' => 'text-base', 'xl' => 'text-xl', default => 'text-xs' })
        ;
    @endphp

    <ui-progress {{ $attributes->class($circularClasses) }} role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="{{ $max }}" data-flux-progress circular>
        <svg class="size-full -rotate-90" viewBox="0 0 {{ $viewBox }} {{ $viewBox }}" fill="none">
            <circle cx="{{ $viewBox / 2 }}" cy="{{ $viewBox / 2 }}" r="{{ $radius }}" stroke="currentColor" stroke-width="{{ $strokeWidth }}" class="{{ $circularTrackClasses }}" />
            <circle cx="{{ $viewBox / 2 }}" cy="{{ $viewBox / 2 }}" r="{{ $radius }}" stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}" class="{{ $circularBarClasses }}" />
        </svg>

        <?php if ($label): ?>
            <div class="{{ $circularLabelClasses }}">
                <?php if ($slot->isNotEmpty()): ?>
                    {{ $slot }}
                <?php else: ?>
                    <span>{{ round($percentage) }}%</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </ui-progress>
    <?php return; ?>
<?php endif; ?>

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
