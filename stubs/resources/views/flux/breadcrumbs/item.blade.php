@pure

@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'separator' => null,
    'iconVariant' => 'mini',
    'icon' => null,
    'href' => null,
])

@php
$classes = Flux::classes()
    ->add('flex items-center')
    ->add('text-sm font-medium')
    ->add('group/breadcrumb')
    ;

$linkClasses = Flux::classes()
    ->add('text-zinc-800 dark:text-white')
    ->add('hover:underline decoration-zinc-800/20 underline-offset-4');

$staticTextClasses = Flux::classes()
    ->add('text-gray-500 dark:text-white/80')
    ;

$separatorClasses = Flux::classes()
    ->add('mx-1 text-zinc-300 dark:text-white/80')
    ->add('group-last/breadcrumb:hidden')
    ;

$iconClasses = Flux::classes()
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : '')
    ;

[ $styleAttributes, $attributes ] = Flux::splitAttributes($attributes);
@endphp

<div {{ $styleAttributes->class($classes) }} data-flux-breadcrumbs-item>
    <?php if ($href): ?>
        <a {{ $attributes->class($linkClasses) }} href="{{ $href }}">
            <?php if ($icon): ?>
                <flux:icon :$icon :variant="$iconVariant" class="{{ $iconClasses }}" />
            <?php else: ?>
                {{ $slot }}
            <?php endif; ?>
        </a>
    <?php else: ?>
        <div {{ $attributes->class($staticTextClasses) }}>
            <?php if ($icon): ?>
                <flux:icon :$icon :variant="$iconVariant" class="{{ $iconClasses }}" />
            <?php else: ?>
                {{ $slot }}
            <?php endif; ?>
        </div>
    <?php endif; ?>

    @if ($separator == null)
        <flux:icon icon="chevron-right" variant="mini" class="{{ $separatorClasses->add('rtl:hidden') }}" />
        <flux:icon icon="chevron-left" variant="mini" class="{{ $separatorClasses->add('hidden rtl:inline') }}" />
    @elseif (! is_string($separator))
        {{ $separator }}
    @elseif ($separator === 'slash')
        <flux:icon icon="slash" variant="mini" class="{{ $separatorClasses->add('rtl:-scale-x-100') }}" />
    @else
        <flux:icon :icon="$separator" variant="mini" class="{{ $separatorClasses }}" />
    @endif
</div>
