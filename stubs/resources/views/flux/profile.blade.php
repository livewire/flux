@php $iconTrailing = $iconTrailing ??= $attributes->pluck('icon:trailing'); @endphp
@php $iconVariant = $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'iconVariant' => 'micro',
    'iconTrailing' => null,
    'initials' => null,
    'chevron' => true,
    'avatar' => null,
    'name' => null,
])

@php
// If no initials are provided, we'll try to generate them from the name by taking the first letter of the first and last name...
$initials ??= collect(explode(' ', $name ?? ''))
    ->map(fn($part) => Str::substr($part, 0, 1))
    ->filter()
    ->only([0, count(explode(' ', $name ?? '')) - 1])
    ->implode('');

// When using the outline icon variant, we need to size it down to match the default icon sizes...
$iconClasses = Flux::classes('text-zinc-400 dark:text-white/80 group-hover:text-zinc-800 dark:group-hover:text-white')
    ->add($iconVariant === 'outline' ? 'size-4' : '');

$classes = Flux::classes()
    ->add('group flex items-center rounded-lg')
    ->add('[ui-dropdown>&]:w-full') // Without this, the "name" won't get truncated in a sidebar dropdown...
    ->add('p-1 hover:bg-zinc-800/5 dark:hover:bg-white/10')
    ;
@endphp

<button type="button" {{ $attributes->class($classes) }} data-flux-profile>
    <div class="shrink-0">
        <?php if (is_string($avatar)): ?>
            <flux:avatar :src="$avatar" size="sm" />
        <?php elseif ($avatar): ?>
            {{ $avatar }}
        <?php else: ?>
            <flux:avatar :$initials :$name size="sm" />
        <?php endif; ?>
    </div>

    <?php if ($name): ?>
        <span class="ml-2 text-sm text-zinc-500 dark:text-white/80 group-hover:text-zinc-800 dark:group-hover:text-white font-medium truncate">
            {{ $name }}
        </span>
    <?php endif; ?>

    <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
        <div class="shrink-0 ml-auto size-8 flex justify-center items-center">
            <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconClasses" />
        </div>
    <?php elseif ($iconTrailing): ?>
        {{ $iconTrailing }}
    <?php elseif ($chevron): ?>
        <div class="shrink-0 ml-auto size-8 flex justify-center items-center">
            <flux:icon.chevron-down :variant="$iconVariant" :class="$iconClasses" />
        </div>
    <?php endif; ?>
</button>
