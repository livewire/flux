@props([
    'collapsible' => null,
    'stashable' => null,
    'sticky' => null,
])

@php
$classes = Flux::classes('[grid-area:sidebar]');

if ($sticky) {
    $attributes = $attributes->merge([
        'x-data' => '',
        'x-bind:style' => '{ position: \'sticky\', top: $el.offsetTop + \'px\', \'max-height\': \'calc(100dvh - \' + $el.offsetTop + \'px)\' }',
        'class' => 'max-h-dvh',
    ]);
}
@endphp

@if ($stashable)
    <flux:sidebar.backdrop />
@endif

<ui-sidebar
    state="expanded"
    stashed
    {{ $attributes->class($classes) }}
    @if (isset($collapsible)) collapsible="{{ $collapsible }}" @endif
    @if (isset($stashable)) stashable @endif
    @if (isset($sticky)) sticky @endif
    data-flux-sidebar>
    <div class="h-full flex flex-col gap-4" data-flux-sidebar-content>
        {{ $slot }}
    </div>
</ui-sidebar>
