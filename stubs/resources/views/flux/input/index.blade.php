@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'iconVariant' => 'mini',
    'variant' => 'outline',
    'iconTrailing' => null,
    'iconLeading' => null,
    'expandable' => null,
    'clearable' => null,
    'copyable' => null,
    'viewable' => null,
    'invalid' => null,
    'type' => 'text',
    'mask' => null,
    'size' => null,
    'icon' => null,
    'kbd' => null,
    'as' => null,
])

@php
$invalid ??= ($name && $errors->has($name));

$iconLeading ??= $icon;

$hasLeadingIcon = (bool) ($iconLeading);
$hasTrailingIcon = (bool) ($iconTrailing) || (bool) $kbd || (bool) $clearable || (bool) $copyable || (bool) $viewable || (bool) $expandable;
$hasBothIcons = $hasLeadingIcon && $hasTrailingIcon;
$hasNoIcons = (! $hasLeadingIcon) && (! $hasTrailingIcon);

$iconClasses = Flux::classes()
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : '')
    ;

$classes = Flux::classes()
    ->add('w-full border rounded-lg block disabled:shadow-none dark:shadow-none')
    ->add('appearance-none') // Without this, input[type="date"] on mobile doesn't respect w-full...
    ->add(match ($size) {
        default => 'text-base sm:text-sm py-2 h-10 leading-[1.375rem]', // This makes the height of the input 40px (same as buttons and such...)
        'sm' => 'text-sm py-1.5 h-8 leading-[1.125rem]',
        'xs' => 'text-xs py-1.5 h-6 leading-[1.125rem]',
    })
    ->add(match (true) { // Spacing...
        $hasNoIcons => 'pl-3 pr-3',
        $hasBothIcons =>'pl-10 pr-10',
        $hasLeadingIcon => 'pl-10 pr-3',
        $hasTrailingIcon => 'pl-3 pr-10',
    })
    ->add(match ($variant) { // Background...
        'outline' => 'bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]',
        'filled'  => 'bg-zinc-800/5 dark:bg-white/10 dark:disabled:bg-white/[7%]',
    })
    ->add(match ($variant) { // Text color
        'outline' => 'text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500',
        'filled'  => 'text-zinc-700 placeholder-zinc-500 disabled:placeholder-zinc-400 dark:text-zinc-200 dark:placeholder-white/60 dark:disabled:placeholder-white/40',
    })
    ->add(match ($variant) { // Border...
        'outline' => $invalid ? 'border-red-500' : 'shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5',
        'filled'  => $invalid ? 'border-red-500' : 'border-0',
    })
    ->add($attributes->pluck('class:input'))
    ;
@endphp

<?php if ($type === 'file'): ?>
    <flux:with-field :$attributes :$name>
        <flux:input.file :$attributes :$name :$size />
    </flux:with-field>
<?php elseif ($as !== 'button'): ?>
    <flux:with-field :$attributes :$name>
        <div {{ $attributes->only('class')->class('w-full relative block group/input') }} data-flux-input>
            <?php if (is_string($iconLeading)): ?>
                <div class="z-10 pointer-events-none absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pl-3 left-0">
                    <flux:icon :icon="$iconLeading" :variant="$iconVariant" :class="$iconClasses" />
                </div>
            <?php elseif ($iconLeading): ?>
                <div {{ $iconLeading->attributes->class('z-10 absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pl-3 left-0') }}>
                    {{ $iconLeading }}
                </div>
            <?php endif; ?>

            <input
                type="{{ $type }}"
                {{-- Leave file inputs unstyled... --}}
                {{ $attributes->except('class')->class($type === 'file' ? '' : $classes) }}
                @isset ($name) name="{{ $name }}" @endisset
                @if ($mask) x-mask="{{ $mask }}" @endif
                @if ($invalid) aria-invalid="true" data-invalid @endif
                @if (is_numeric($size)) size="{{ $size }}" @endif
                data-flux-control
                data-flux-group-target
            >

            <?php if ($kbd): ?>
                <div class="pointer-events-none absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400 pr-4 right-0">
                    {{ $kbd }}
                </div>
            <?php endif; ?>

            <?php if (is_string($iconTrailing)): ?>
                <div class="pointer-events-none absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pr-3 right-0">
                    <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconClasses" />
                </div>
            <?php elseif ($iconTrailing): ?>
                <div {{ $iconTrailing->attributes->class('absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pr-2 right-0') }}>
                    {{ $iconTrailing }}
                </div>
            <?php endif; ?>

            <?php if ($expandable): ?>
                <div class="absolute top-0 bottom-0 flex items-center justify-center pr-2 right-0">
                    <flux:input.expandable :$size />
                </div>
            <?php endif; ?>

            <?php if ($clearable): ?>
                <div class="absolute top-0 bottom-0 flex items-center justify-center pr-2 right-0">
                    <flux:input.clearable :$size />
                </div>
            <?php endif; ?>

            <?php if ($copyable): ?>
                <div class="absolute top-0 bottom-0 flex items-center justify-center pr-2 right-0">
                    <flux:input.copyable :$size />
                </div>
            <?php endif; ?>

            <?php if ($viewable): ?>
                <div class="absolute top-0 bottom-0 flex items-center justify-center pr-2 right-0">
                    <flux:input.viewable :$size />
                </div>
            <?php endif; ?>
        </div>
    </flux:with-field>
<?php else: ?>
    <button {{ $attributes->merge(['type' => 'button'])->class([$classes, 'w-full relative flex']) }}>
        <?php if (is_string($iconLeading)): ?>
            <div class="z-10 absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pl-3 left-0">
                <flux:icon :icon="$iconLeading" :variant="$iconVariant" :class="$iconClasses" />
            </div>
        <?php elseif ($iconLeading): ?>
            <div {{ $iconLeading->attributes->class('z-10 absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pl-3 left-0') }}>
                {{ $iconLeading }}
            </div>
        <?php endif; ?>

        <?php if ($attributes->has('placeholder')): ?>
            <div class="block self-center text-left flex-1 font-medium text-zinc-400 dark:text-white/40">
                {{ $attributes->get('placeholder') }}
            </div>
        <?php else: ?>
            <div class="text-left self-center flex-1 font-medium text-zinc-800 dark:text-white">
                {{ $slot }}
            </div>
        <?php endif; ?>

        <?php if ($kbd): ?>
            <div class="absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pr-4 right-0">
                {{ $kbd }}
            </div>
        <?php endif; ?>

        <?php if (is_string($iconTrailing)): ?>
            <div class="absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pr-3 right-0">
                <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconClasses" />
            </div>
        <?php elseif  ($iconTrailing): ?>
            <div {{ $iconTrailing->attributes->class('absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pr-2 right-0') }}>
                {{ $iconTrailing }}
            </div>
        <?php endif; ?>
    </button>
<?php endif; ?>
