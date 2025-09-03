@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'name' => null,
    'align' => 'right',
    'icons' => false,
    'iconOn' => 'check',
    'iconOff' => 'x-mark',
    'iconVariant' => 'mini',
])

@php
// We only want to show the name attribute it has been set manually
// but not if it has been set from the `wire:model` attribute...
$showName = isset($name);
if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

// Icons: show ONLY if `icons` attribute is present.
if ($icons) {
    $hasIconOnAttr = $attributes->has('icon:on');
    $hasIconOffAttr = $attributes->has('icon:off');

    if ($hasIconOnAttr && $hasIconOffAttr) {
        $iconOn = $attributes->pluck('icon:on');
        $iconOff = $attributes->pluck('icon:off');
    } elseif ($hasIconOnAttr) {
        $iconOn = $attributes->pluck('icon:on');
        $iconOff = null;
    } elseif ($hasIconOffAttr) {
        $iconOn = null;
        $iconOff = $attributes->pluck('icon:off');
    } else {
        $iconOn = is_object($iconOn) ? $iconOn?->attributes?->pluck('on') : $iconOn;
        $iconOff = is_object($iconOff) ? $iconOff?->attributes?->pluck('off') : $iconOff;
    }
} else {
    $iconOn = null;
    $iconOff = null;
}

$classes = Flux::classes()
    ->add('group h-5 w-8 min-w-8 relative inline-flex items-center outline-offset-2')
    ->add('rounded-full')
    ->add('transition')
    ->add('bg-zinc-800/15 [&[disabled]]:opacity-50 dark:bg-transparent dark:border dark:border-white/20 dark:[&[disabled]]:border-white/10')
    ->add('[print-color-adjust:exact]')
    ->add([
        'data-checked:bg-(--color-accent)',
        'data-checked:border-0',
    ])
    ;

$indicatorClasses = Flux::classes()
    ->add('grid place-items-center')
    ->add('size-3.5')
    ->add('rounded-full')
    ->add('transition translate-x-[3px] dark:translate-x-[2px] rtl:-translate-x-[3px] dark:rtl:-translate-x-[2px]')
    ->add('bg-white')
    ->add([
        'group-data-checked:translate-x-[15px] rtl:group-data-checked:-translate-x-[15px]',
        'group-data-checked:bg-(--color-accent-foreground)',
    ]);

$iconClasses = Flux::classes()
    ->add('size-2.5');
@endphp

@if ($align === 'left' || $align === 'start')
    <flux:with-inline-field :$attributes>
        <ui-switch {{ $attributes->class($classes) }} @if($showName) name="{{ $name }}" @endif data-flux-control data-flux-switch>
            <span class="{{ \Illuminate\Support\Arr::toCssClasses($indicatorClasses) }}">
                @if($icons)
                    @if($iconOff)
                        <flux:icon name="{{ $iconOff }}" variant="{{ $iconVariant }}" class="{{ $iconClasses }} block text-(--color-accent-content) dark:text-(--color-accent-foreground) group-data-checked:hidden"></flux:icon>
                    @endif
                    @if($iconOn)
                        <flux:icon name="{{ $iconOn }}" variant="{{ $iconVariant }}" class="{{ $iconClasses }} hidden text-(--color-accent-content) dark:text-(--color-accent-content) group-data-checked:block"></flux:icon>
                    @endif
                @endif
            </span>
        </ui-switch>
    </flux:with-inline-field>
@else
    <flux:with-reversed-inline-field :$attributes>
        <ui-switch {{ $attributes->class($classes) }} @if($showName) name="{{ $name }}" @endif data-flux-control data-flux-switch>
            <span class="{{ \Illuminate\Support\Arr::toCssClasses($indicatorClasses) }}">
                @if($icons)
                    @if($iconOff)
                        <flux:icon name="{{ $iconOff }}" variant="{{ $iconVariant }}" class="{{ $iconClasses }} block text-(--color-accent-content) dark:text-(--color-accent-foreground) group-data-checked:hidden"></flux:icon>
                    @endif
                    @if($iconOn)
                        <flux:icon name="{{ $iconOn }}" variant="{{ $iconVariant }}" class="{{ $iconClasses }} hidden text-(--color-accent-content) dark:text-(--color-accent-content) group-data-checked:block"></flux:icon>
                    @endif
                @endif
            </span>
        </ui-switch>
    </flux:with-reversed-inline-field>
@endif
