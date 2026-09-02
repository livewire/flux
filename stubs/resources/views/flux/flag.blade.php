@blaze(memo: true)

@props([
    'country' => null,
    'src' => null,
    'alt' => '',
    'size' => 'sm',
    'circle' => false,
])

@php
$country = is_string($country) ? strtoupper(trim($country)) : null;
$src ??= $country ? Flux::flagUrl($country) : null;

$classes = Flux::classes()
    ->add(match ($size) {
        'xl' => '[:where(&)]:w-12',
        'lg' => '[:where(&)]:w-10',
        'md' => '[:where(&)]:w-8',
        default => '[:where(&)]:w-6',
        'xs' => '[:where(&)]:w-5',
    })
    ->add($circle ? 'aspect-square rounded-full' : 'aspect-[3/2] rounded-[2px]')
    ->add('relative isolate block flex-none overflow-hidden bg-zinc-100 dark:bg-zinc-800')
    ->add([
        'after:absolute after:inset-0 after:inset-ring-[1px] after:inset-ring-black/7 dark:after:inset-ring-white/10',
        $circle ? 'after:rounded-full' : 'after:rounded-[2px]',
    ]);
@endphp

<?php if ($src): ?>
    <span
        {{ $attributes->class($classes)->merge([
            'data-flux-flag' => '',
            'data-country' => $country,
        ]) }}
    >
        <img
            src="{{ $country ? $src : url($src) }}"
            alt="{{ $alt }}"
            loading="lazy"
            decoding="async"
            class="size-full object-cover"
        >
    </span>
<?php else: ?>
    <span
        role="img"
        @if ($alt) aria-label="{{ $alt }}" @else aria-hidden="true" @endif
        {{ $attributes->class($classes)->merge([
            'data-flux-flag' => '',
            'data-country' => $country,
        ]) }}
    >
        <span class="flex size-full items-center justify-center">
            <flux:icon.globe-alt variant="micro" class="size-2/3 text-zinc-400 dark:text-zinc-500" />
        </span>
    </span>
<?php endif; ?>
