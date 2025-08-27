@props([
    'collapsible' => null,
    'stashable' => null,
    'sticky' => null,
])

@php
$classes = Flux::classes('[grid-area:sidebar]');

/*if ($sticky) {
    $attributes = $attributes->merge([
        'x-data' => '',
        'x-bind:style' => '{ position: \'sticky\', top: $el.offsetTop + \'px\', \'max-height\': \'calc(100dvh - \' + $el.offsetTop + \'px)\' }',
        'class' => 'max-h-dvh',
    ]);
}*/

$stashable = match($stashable) {
    'false' => 'false',
    false => 'false',
    default => null,
};

$collapsible = match($collapsible) {
    'true' => 'true',
    true => 'true',
    'icon' => 'icon',
    'false' => 'false',
    false => 'false',
    default => null,
};

// If collapsible is not set, try stashable for backwards compatibility...
if (is_null($collapsible)) {
    $collapsible = $stashable;
}
@endphp

@if (isset($collapsible) && $collapsible !== 'false')
    <flux:sidebar.backdrop />
@endif

<ui-sidebar
    state="expanded"
    stashed
    {{ $attributes->class($classes) }}
    @if (isset($collapsible)) collapsible="{{ $collapsible }}" @endif
    @if (isset($sticky)) sticky @endif
    data-flux-sidebar>
    <div class="h-full flex flex-col gap-4" data-flux-sidebar-content>
        {{ $slot }}
    </div>
</ui-sidebar>
