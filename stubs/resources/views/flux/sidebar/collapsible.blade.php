@props([
    'collapsible' => null,
    'stashable' => null,
    'sticky' => null,
])

@php
$classes = Flux::classes('[grid-area:sidebar]');

$collapsible = match($collapsible) {
    'true' => 'true',
    true => 'true',
    'icon' => 'icon',
    'mobile' => 'mobile',
    'false' => null,
    false => null,
    default => null,
};

// If collapsible is not set, try stashable for backwards compatibility...
if (is_null($collapsible)) {
    $collapsible = match($stashable) {
        'true' => 'true',
        true => 'true',
        'false' => null,
        false => null,
        default => null,
    };
}
@endphp

@if (isset($collapsible) && $collapsible !== 'false')
    <flux:sidebar.backdrop />
@endif

<ui-sidebar
    state="expanded"
    mobile-state="collapsed"
    {{ $attributes->class($classes) }}
    @if (isset($collapsible)) collapsible="{{ $collapsible }}" @endif
    @if (isset($sticky)) sticky @endif
    data-flux-sidebar>
    <div class="h-full flex flex-col gap-4" data-flux-sidebar-content>
        {{ $slot }}
    </div>
</ui-sidebar>
