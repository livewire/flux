@blaze(fold: true, unsafe: ['logo:dark', 'icon:trailing', 'icon:variant'])

@php $logoDark ??= $attributes->pluck('logo:dark'); @endphp
@php $iconTrailing ??= $attributes->pluck('icon:trailing'); @endphp
@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'iconTrailing' => null,
    'iconVariant' => 'micro',
    'name' => null,
    'logo' => null,
    'logoDark' => null,
    'alt' => null,
    'href' => '/',
    'as' => null,
])

@php
$href = $as === 'button' ? null : $href;

$classes = Flux::classes()
    ->add('h-10 min-w-0 flex items-center px-2 in-data-flux-sidebar-collapsed-desktop:w-10 in-data-flux-sidebar-collapsed-desktop:px-0 in-data-flux-sidebar-collapsed-desktop:justify-center')
    ->add('in-data-flux-sidebar-collapsed-desktop:in-data-flux-sidebar-active:absolute')
    ->add('in-data-flux-sidebar-collapsed-desktop:in-data-flux-sidebar-active:opacity-0')
    ->add($as === 'button' ? 'group select-none rounded-lg hover:bg-zinc-800/5 in-data-open:bg-zinc-800/5 dark:hover:bg-white/15 dark:in-data-open:bg-white/15' : '')
    ;

$textClasses = Flux::classes()
    ->add('min-w-0 text-sm font-medium truncate [:where(&)]:text-zinc-800 dark:[:where(&)]:text-zinc-100')
    ;

$iconClasses = Flux::classes()
    ->add('shrink-0 text-zinc-400 group-hover:text-zinc-800 in-data-open:text-zinc-800 dark:text-white/80 dark:group-hover:text-white dark:in-data-open:text-white')
    ->add('in-data-flux-sidebar-collapsed-desktop:hidden')
    ->add($iconVariant === 'outline' ? 'size-4' : '')
    ;
@endphp

<?php if ($name): ?>
    <flux:button-or-link-pure :$as :$href :attributes="$attributes->class([ $classes, 'gap-2' ])" data-flux-sidebar-brand>
        <?php if ($logo instanceof \Illuminate\View\ComponentSlot): ?>
            <div {{ $logo->attributes->class('flex items-center justify-center [:where(&)]:h-6 [:where(&)]:min-w-6 [:where(&)]:rounded-sm overflow-hidden shrink-0') }}>
                {{ $logo }}
            </div>
        <?php else: ?>
            <div class="flex items-center justify-center h-6 min-w-6 rounded-sm overflow-hidden shrink-0">
                <?php if ($logoDark): ?>
                    <img src="{{ $logo }}" alt="{{ $alt }}" class="h-6 min-w-6 dark:hidden" />
                    <img src="{{ $logoDark }}" alt="{{ $alt }}" class="h-6 min-w-6 hidden dark:block" />
                <?php elseif ($logo): ?>
                    <img src="{{ $logo }}" alt="{{ $alt }}" class="h-6 min-w-6" />
                <?php else: ?>
                    {{ $slot }}
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="{{ $textClasses }} in-data-flux-sidebar-collapsed-desktop:hidden">{{ $name }}</div>

        <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
            <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconClasses" />
        <?php elseif ($iconTrailing): ?>
            {{ $iconTrailing }}
        <?php endif; ?>
    </flux:button-or-link-pure>
<?php else: ?>
    <flux:button-or-link-pure :$as :$href :attributes="$attributes->class($classes)" data-flux-sidebar-brand>
        <?php if ($logo instanceof \Illuminate\View\ComponentSlot): ?>
            <div {{ $logo->attributes->class('flex items-center justify-center [:where(&)]:h-6 [:where(&)]:min-w-6 [:where(&)]:rounded-sm overflow-hidden shrink-0') }}>
                {{ $logo }}
            </div>
        <?php else: ?>
            <div class="flex items-center justify-center h-6 rounded-sm overflow-hidden shrink-0">
                <?php if ($logoDark): ?>
                    <img src="{{ $logo }}" alt="{{ $alt }}" class="h-6 dark:hidden" />
                    <img src="{{ $logoDark }}" alt="{{ $alt }}" class="h-6 hidden dark:block" />
                <?php elseif ($logo): ?>
                    <img src="{{ $logo }}" alt="{{ $alt }}" class="h-6" />
                <?php else: ?>
                    {{ $slot }}
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
            <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$iconClasses" />
        <?php elseif ($iconTrailing): ?>
            {{ $iconTrailing }}
        <?php endif; ?>
    </flux:button-or-link-pure>
<?php endif; ?>
