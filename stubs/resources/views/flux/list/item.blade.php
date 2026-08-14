@blaze(fold: true, unsafe: ['icon:trailing', 'icon:variant'])

@php $iconTrailing ??= $attributes->pluck('icon:trailing'); @endphp
@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@aware([ 'variant' ])

@props([
    'iconTrailing' => null,
    'iconVariant' => 'mini',
    'variant' => null,
    'heading' => null,
    'description' => null,
    'hover' => null,
    'href' => null,
    'as' => 'div',
    'icon' => null,
])

@php
$hover ??= $href || $as === 'button';

$classes = Flux::classes()
    ->add('flex items-center w-full text-start')
    ->add($variant === 'bare' ? 'px-4 py-3.5' : 'px-4 py-4')
    ->add($variant === 'bare' ? 'rounded-lg' : null)
    ->add($hover ? 'hover:bg-zinc-800/4 dark:hover:bg-white/7' : null)
    ;

$leadingClasses = Flux::classes()
    ->add('mr-4 flex items-start *:data-flux-checkbox:mt-0')
    ;

$iconClasses = Flux::classes()
    ->add('[:where(&)]:text-zinc-400 [:where(&)]:dark:text-white/60')
    ->add($iconVariant === 'outline' ? 'size-5' : '')
    ->add($attributes->pluck('icon:class'))
    ;

$trailingClasses = Flux::classes()
    ->add('ml-auto flex items-center *:data-flux-checkbox:mt-0')
    ->add($description ? 'mr-1.75' : '')
    ;

$iconTrailingClasses = Flux::classes()
    ->add('[:where(&)]:text-zinc-400 [:where(&)]:dark:text-white/60')
    ->add($iconVariant === 'outline' ? 'size-5' : '')
    ->add($attributes->pluck('icon-trailing:class'))
    ;

$contentClasses = Flux::classes()
    ->add('text-sm font-medium text-zinc-800 dark:text-white')
    ->add('*:[[data-flux-heading]:has(+[data-flux-subheading])]:mb-0.5')
    ;
@endphp

<flux:button-or-link :attributes="$attributes->class($classes)" :$as :$href data-flux-list-item>
    <?php if (is_string($icon) && $icon !== ''): ?>
        <div class="{{ $leadingClasses }}">
            <flux:icon :$icon :variant="$iconVariant" :class="$iconClasses" />
        </div>
    <?php elseif ($icon): ?>
        <div class="{{ $leadingClasses }} text-zinc-400 dark:text-white/60">
            {{ $icon }}
        </div>
    <?php elseif (isset($leading)): ?>
        <div class="{{ $leadingClasses }}">
            {{ $leading }}
        </div>
    <?php endif; ?>

    <div class="{{ $contentClasses }}">
        {{ $slot }}
    </div>

    <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
        <div class="{{ $trailingClasses }}">
            <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconTrailingClasses" />
        </div>
    <?php elseif ($iconTrailing): ?>
        <div class="{{ $trailingClasses }} text-zinc-400 dark:text-white/60">
            {{ $iconTrailing }}
        </div>
    <?php elseif (isset($trailing)): ?>
        <div class="{{ $trailingClasses }}">
            {{ $trailing }}
        </div>
    <?php endif; ?>
</flux:button-or-link>
