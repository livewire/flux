@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'iconVariant' => 'solid',
    'initials' => null,
    'tooltip' => null,
    'circle' => null,
    'color' => null,
    'badge' => null,
    'name' => null,
    'icon' => null,
    'size' => 'md',
    'src' => null,
    'href' => null,
    'alt' => null,
    'as' => 'div',
])

@php
if ($name && ! $initials) {
    $parts = explode(' ', trim($name));

    if ($attributes->pluck('initials:single')) {
        $initials = strtoupper(mb_substr($parts[0], 0, 1));
    } else {
        // Remove empty strings from the array...
        $parts = collect($parts)->filter()->values()->all();

        if (count($parts) > 1) {
            $initials = strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1));
        } else if (count($parts) === 1) {
            $initials = strtoupper(mb_substr($parts[0], 0, 1)) . strtolower(mb_substr($parts[0], 1, 1));
        }
    }
}

if ($name && $tooltip === true) {
    $tooltip = $name;
}

$hasTextContent = $icon ?? $initials ?? $slot->isNotEmpty();

// If there's no text content, we'll fallback to using the user icon otherwise there will be an empty white square...
if (! $hasTextContent) {
    $icon = 'user';
    $hasTextContent = true;
}

// Be careful not to change the order of these colors.
// They're used in the hash function below and changing them would change actual user avatar colors that they might have grown to identify with.
$colors = ['red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'];

if ($hasTextContent && $color === 'auto') {
    $colorSeed = $attributes->pluck('color:seed') ?? $name ?? $icon ?? $initials ?? $slot;
    $hash = crc32((string) $colorSeed);
    $color = $colors[$hash % count($colors)];
}

$classes = Flux::classes()
    ->add(match($size) {
        'xl' => '[:where(&)]:size-16 [:where(&)]:text-base',
        'lg' => '[:where(&)]:size-12 [:where(&)]:text-base',
        default => '[:where(&)]:size-10 [:where(&)]:text-sm',
        'sm' => '[:where(&)]:size-8 [:where(&)]:text-sm',
        'xs' => '[:where(&)]:size-6 [:where(&)]:text-xs',
    })
    ->add($circle ? '[--avatar-radius:calc(infinity*1px)]' : match($size) {
        'xl' => '[--avatar-radius:var(--radius-xl)]',
        'lg' => '[--avatar-radius:var(--radius-lg)]',
        default => '[--avatar-radius:var(--radius-lg)]',
        'sm' => '[--avatar-radius:var(--radius-md)]',
        'xs' => '[--avatar-radius:var(--radius-sm)]',
    })
    ->add('relative flex-none isolate flex items-center justify-center')
    ->add('[:where(&)]:font-medium')
    ->add('rounded-[var(--avatar-radius)]')
    ->add($hasTextContent ? '[:where(&)]:bg-zinc-200 [:where(&)]:dark:bg-zinc-600 [:where(&)]:text-zinc-800 [:where(&)]:dark:text-white' : '')
    ->add(match($color) {
        'red' => 'bg-red-200 text-red-800',
        'orange' => 'bg-orange-200 text-orange-800',
        'amber' => 'bg-amber-200 text-amber-800',
        'yellow' => 'bg-yellow-200 text-yellow-800',
        'lime' => 'bg-lime-200 text-lime-800',
        'green' => 'bg-green-200 text-green-800',
        'emerald' => 'bg-emerald-200 text-emerald-800',
        'teal' => 'bg-teal-200 text-teal-800',
        'cyan' => 'bg-cyan-200 text-cyan-800',
        'sky' => 'bg-sky-200 text-sky-800',
        'blue' => 'bg-blue-200 text-blue-800',
        'indigo' => 'bg-indigo-200 text-indigo-800',
        'violet' => 'bg-violet-200 text-violet-800',
        'purple' => 'bg-purple-200 text-purple-800',
        'fuchsia' => 'bg-fuchsia-200 text-fuchsia-800',
        'pink' => 'bg-pink-200 text-pink-800',
        'rose' => 'bg-rose-200 text-rose-800',
        default => '',
    })
    ->add(true ? [
        'after:absolute after:inset-0 after:inset-ring-[1px] after:inset-ring-black/7 dark:after:inset-ring-white/10',
        $circle ? 'after:rounded-full' : match($size) {
            'xl' => 'after:rounded-xl',
            'lg' => 'after:rounded-lg',
            default => 'after:rounded-lg',
            'sm' => 'after:rounded-md',
            'xs' => 'after:rounded-sm',
        },
    ] : []);

$iconClasses = Flux::classes()
    ->add('opacity-75')
    ->add(match($size) {
        'lg' => 'size-8',
        default => 'size-6',
        'sm' => 'size-5',
        'xs' => 'size-4',
    });

$badgeColor = $attributes->pluck('badge:color') ?: (is_object($badge) ? $badge?->attributes?->pluck('color') : null);
$badgeCircle = $attributes->pluck('badge:circle') ?: (is_object($badge) ? $badge?->attributes?->pluck('circle') : null);
$badgePosition = $attributes->pluck('badge:position') ?: (is_object($badge) ? $badge?->attributes?->pluck('position') : null);
$badgeVariant = $attributes->pluck('badge:variant') ?: (is_object($badge) ? $badge?->attributes?->pluck('variant') : null);

$badgeClasses = Flux::classes()
    ->add('absolute ring-[2px] ring-white dark:ring-zinc-900 z-10')
    ->add(match($size) {
        default => 'h-3 min-w-3',
        'sm' => 'h-2 min-w-2',
        'xs' => 'h-2 min-w-2',
    })
    ->add('flex items-center justify-center tabular-nums overflow-hidden')
    ->add('text-[.625rem] text-zinc-800 dark:text-white font-medium')
    ->add($badgeCircle ? 'rounded-full' : 'rounded-[3px]')
    ->add($badgeVariant === 'outline' ? [
        'after:absolute after:inset-[3px] after:bg-white dark:after:bg-zinc-900',
        $badgeCircle ? 'after:rounded-full' : 'after:rounded-[1px]',
    ] : [])
    ->add(match($badgePosition) {
        'top left' => 'top-0 left-0',
        'top right' => 'top-0 right-0',
        'bottom left' => 'bottom-0 left-0',
        'bottom right' => 'bottom-0 right-0',
        default => 'bottom-0 right-0',
    })
    ->add(match($badgeColor) {
        'red' => 'bg-red-500 dark:bg-red-400',
        'orange' => 'bg-orange-500 dark:bg-orange-400',
        'amber' => 'bg-amber-500 dark:bg-amber-400',
        'yellow' => 'bg-yellow-500 dark:bg-yellow-400',
        'lime' => 'bg-lime-500 dark:bg-lime-400',
        'green' => 'bg-green-500 dark:bg-green-400',
        'emerald' => 'bg-emerald-500 dark:bg-emerald-400',
        'teal' => 'bg-teal-500 dark:bg-teal-400',
        'cyan' => 'bg-cyan-500 dark:bg-cyan-400',
        'sky' => 'bg-sky-500 dark:bg-sky-400',
        'blue' => 'bg-blue-500 dark:bg-blue-400',
        'indigo' => 'bg-indigo-500 dark:bg-indigo-400',
        'violet' => 'bg-violet-500 dark:bg-violet-400',
        'purple' => 'bg-purple-500 dark:bg-purple-400',
        'fuchsia' => 'bg-fuchsia-500 dark:bg-fuchsia-400',
        'pink' => 'bg-pink-500 dark:bg-pink-400',
        'rose' => 'bg-rose-500 dark:bg-rose-400',
        'zinc' => 'bg-zinc-400 dark:bg-zinc-300',
        'gray' => 'bg-zinc-400 dark:bg-zinc-300',
        default => 'bg-white dark:bg-zinc-900',
    })
    ;

$label = $alt ?? $name;
@endphp

<flux:with-tooltip :$tooltip :$attributes>
    <flux:button-or-link :attributes="$attributes->class($classes)->merge($circle ? ['data-circle' => 'true'] : [])" :$as :$href data-flux-avatar data-slot="avatar" data-size="{{ $size }}">
        <?php if ($src): ?>
            <img src="{{ $src }}" alt="{{ $alt ?? $name }}" class="rounded-[var(--avatar-radius)] size-full object-cover">
        <?php elseif ($icon): ?>
            <flux:icon :name="$icon" :variant="$iconVariant" :class="$iconClasses" />
        <?php elseif ($hasTextContent): ?>
            <span class="select-none">{{ $initials ?? $slot }}</span>
        <?php endif; ?>

        <?php if ($badge instanceof \Illuminate\View\ComponentSlot): ?>
            <div {{ $badge->attributes->class($badgeClasses) }} aria-hidden="true">{{ $badge }}</div>
        <?php elseif ($badge): ?>
            <div class="{{ $badgeClasses }}" aria-hidden="true">{{ is_string($badge) ? $badge : '' }}</div>
        <?php endif; ?>
    </flux:button-or-link>
</flux:with-tooltip>
