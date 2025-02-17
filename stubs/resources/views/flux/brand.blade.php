@props([
    'name' => null,
    'logo' => null,
    'href' => '/',
])

@php
$classes = Flux::classes()
    ->add('h-10 flex items-center mr-4')
    ;

$textClasses = Flux::classes()
    ->add('text-sm font-medium truncate [:where(&)]:text-zinc-800 dark:[:where(&)]:text-zinc-100')
    ;
@endphp

<?php if ($name): ?>
    <a href="{{ $href }}" {{ $attributes->class([ $classes, 'gap-2' ])->except('alt') }} data-flux-brand>
        <div class="size-6 rounded-sm overflow-hidden shrink-0">
            <?php if (is_string($logo)): ?>
                <img src="{{ $logo }}" {{ $attributes->only('alt') }} />
            <?php else: ?>
                {{ $logo ?? $slot }}
            <?php endif; ?>
        </div>

        <div class="{{ $textClasses }}">{{ $name }}</div>
    </a>
<?php else: ?>
    <a href="{{ $href }}" {{ $attributes->class($classes)->except('alt') }} data-flux-brand>
        <div class="size-8 rounded-sm overflow-hidden shrink-0">
            <?php if (is_string($logo)): ?>
                <img src="{{ $logo }}" {{ $attributes->only('alt') }} />
            <?php else: ?>
                {{ $logo ?? $slot }}
            <?php endif; ?>
        </div>
    </a>
<?php endif; ?>
