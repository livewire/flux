@props([
    'name' => null,
    'logo' => null,
    'alt' => null,
    'href' => '/',
])

@php
$classes = Flux::classes()
    ->add('h-10 flex items-center me-4')
    ;

$textClasses = Flux::classes()
    ->add('text-sm font-medium truncate [:where(&)]:text-zinc-800 dark:[:where(&)]:text-zinc-100')
    ;
@endphp

<?php if ($name): ?>
    <a href="{{ $href }}" {{ $attributes->class([ $classes, 'gap-2' ]) }} data-flux-brand>
        <?php if ($logo instanceof \Illuminate\View\ComponentSlot): ?>
            <div {{ $logo->attributes->class('flex items-center justify-center [:where(&)]:size-6 [:where(&)]:rounded-sm overflow-hidden shrink-0') }}>
                {{ $logo }}
            </div>
        <?php else: ?>
            <div class="flex items-center justify-center size-6 rounded-sm overflow-hidden shrink-0">
                <?php if ($logo): ?>
                    <img src="{{ $logo }}" alt="{{ $alt }}" />
                <?php else: ?>
                    {{ $slot }}
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="{{ $textClasses }}">{{ $name }}</div>
    </a>
<?php else: ?>
    <a href="{{ $href }}" {{ $attributes->class($classes) }} data-flux-brand>
        <?php if ($logo instanceof \Illuminate\View\ComponentSlot): ?>
            <div {{ $logo->attributes->class('flex items-center justify-center [:where(&)]:size-6 [:where(&)]:rounded-sm overflow-hidden shrink-0') }}>
                {{ $logo }}
            </div>
        <?php else: ?>
            <div class="flex items-center justify-center size-6 rounded-sm overflow-hidden shrink-0">
                <?php if ($logo): ?>
                    <img src="{{ $logo }}" alt="{{ $alt }}" />
                <?php else: ?>
                    {{ $slot }}
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </a>
<?php endif; ?>
