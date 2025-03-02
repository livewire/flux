@props([
    'name' => null,
    'logo' => null,
    'href' => '/',
])

@php
    $classes = Flux::classes()->add('h-10 flex items-center mr-4');

    $textClasses = Flux::classes()->add(
        'text-sm font-medium truncate [:where(&)]:text-zinc-800 dark:[:where(&)]:text-zinc-100',
    );
@endphp

<a {{ $attributes->class([$classes, 'gap-2' => $name !== null])->except('alt') }} data-flux-brand
    href="{{ $href }}">
    <div @class([
        'rounded-sm overflow-hidden shrink-0',
        'hidden' => $logo === null,
        'inline-flex align-middle' => $logo !== null,
        'size-8' => $name === null,
        'size-6' => $name !== null,
    ])>
        <?php if (is_string($logo)): ?>
        <img {{ $attributes->only('alt') }} class="object-contain" src="{{ $logo }}" />
        <?php else: ?>
        {{ $logo ?? $slot }}
        <?php endif; ?>
    </div>
    <?php if ($name): ?>
    <div class="{{ $textClasses }}">{{ $name }}</div>
    <?php endif; ?>
</a>
