@props([
    'expandable' => false,
    'expanded' => true,
    'heading' => null,
    'iconDot' => null,
    'icon' => null,
])

<?php if ($expandable && $heading): ?>
    <ui-disclosure {{ $attributes->class('group/disclosure') }} @if ($expanded === true) open @endif data-flux-navlist-group>
        <button type="button" class="px-3 gap-3 w-full h-10 lg:h-8 border border-transparent flex items-center text-start group/disclosure-button mb-[2px] rounded-lg hover:bg-zinc-800/5 dark:hover:bg-white/[7%] text-zinc-500 hover:text-zinc-800 dark:text-white/80 dark:hover:text-white">
            @if ($icon)
                <div class="relative" data-icon>
                    <?php if (is_string($icon) && $icon !== ''): ?>
                        <flux:icon :$icon :attributes="Flux::attributesAfter('icon:', $attributes, ['class' => 'size-4!'])" />
                    <?php else: ?>
                        {{ $icon }}
                    <?php endif; ?>

                    <?php if ($iconDot): ?>
                        <div class="absolute top-[-2px] end-[-2px]">
                            <div class="size-[6px] rounded-full bg-zinc-500 dark:bg-zinc-400"></div>
                        </div>
                    <?php endif; ?>
                </div>
            @else
                <div class="px-0.5" data-icon>
                    <flux:icon.chevron-down class="size-3! hidden group-data-open/disclosure-button:block" />
                    <flux:icon.chevron-right class="size-3! block group-data-open/disclosure-button:hidden rtl:rotate-180" />
                </div>
            @endif

            <span class="flex-1 text-sm font-medium leading-none" data-content>{{ $heading }}</span>

            @if ($icon)
                <div class="px-0.5" data-icon-trailing>
                    <flux:icon.chevron-down class="size-3! hidden group-data-open/disclosure-button:block" />
                    <flux:icon.chevron-right class="size-3! block group-data-open/disclosure-button:hidden rtl:rotate-180" />
                </div>
            @endif
        </button>

        <div class="relative hidden data-open:block space-y-[2px] ps-7" @if ($expanded === true) data-open @endif data-group-content>
            <div class="absolute inset-y-[3px] w-px bg-zinc-200 dark:bg-white/30 start-0 ms-5"></div>

            {{ $slot }}
        </div>
    </ui-disclosure>
<?php elseif ($heading): ?>
    <div {{ $attributes->class('block space-y-[2px]') }}>
        <div class="px-3 py-2">
            <div class="text-sm text-zinc-400 font-medium leading-none">{{ $heading }}</div>
        </div>

        <div>
            {{ $slot }}
        </div>
    </div>
<?php else: ?>
    <div {{ $attributes->class('block space-y-[2px]') }}>
        {{ $slot }}
    </div>
<?php endif; ?>
