@props([
    'initials' => null,
    'circle' => null,
    'icon' => null,
    'size' => null,
    'src' => null,
    'href' => null,
    'as' => 'div',
])

@php
$hasTextContent = $initials ?? $slot->isNotEmpty();

$classes = Flux::classes()
    ->add('overflow-hidden flex items-center justify-center')
    ->add('[:where(&)]:text-sm [:where(&)]:font-medium')
    ->add(match ($size) {
        'lg' => '[:where(&)]:size-12 [:where(&)]:rounded-lg',
        default => '[:where(&)]:size-10 [:where(&)]:rounded-md',
        'sm' => '[:where(&)]:size-8 [:where(&)]:rounded-sm',
        'xs' => '[:where(&)]:size-6 [:where(&)]:rounded-sm',
    })
    ->add($circle ? 'rounded-full' : '')
    ->add($hasTextContent ? '[:where(&)]:bg-zinc-200 [:where(&)]:dark:bg-zinc-700' : '')
    ;
@endphp

<flux:button-or-link :attributes="$attributes->class($classes)" :$as :$href data-flux-avatar>
    @if ($src)
        <img src="{{ $src }}" alt="" />
    @elseif ($hasTextContent)
        <span>{{ $initials ?? $slot }}</span>
    @endif
</flux:button-or-link>
