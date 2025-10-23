@blaze

@props([
    'collapsible' => null,
    'stashable' => null, // @deprecated
    'sticky' => null,
])

@php
$collapsibleOnMobile = $stashable || $collapsible === 'mobile' || $collapsible === true;

if ($stashable && $collapsible === null) {
    $collapsible = 'mobile';
}

$classes = Flux::classes('[grid-area:sidebar]')
    ->add('z-1 flex flex-col gap-4 [:where(&)]:w-64 p-4')
    ->add('data-flux-sidebar-collapsed-desktop:w-14 data-flux-sidebar-collapsed-desktop:px-2')
    ->add('data-flux-sidebar-collapsed-desktop:cursor-e-resize rtl:data-flux-sidebar-collapsed-desktop:cursor-w-resize')
    ;

if ($sticky) {
    $attributes = $attributes->merge([
        'class' => 'max-h-dvh overflow-y-auto overscroll-contain',
    ]);
}

if ($collapsibleOnMobile) {
    $attributes = $attributes->merge([
        // Prevent mobile sidebar from transitioning out on load...
        'x-init' => '$el.classList.add(\'transition-transform\')',
    ])->class([
        // Prevent mobile sidebar from flashing on-load...
        'max-lg:data-flux-sidebar-cloak:hidden',
        'data-flux-sidebar-on-mobile:data-flux-sidebar-collapsed-mobile:-translate-x-full data-flux-sidebar-on-mobile:data-flux-sidebar-collapsed-mobile:rtl:translate-x-full',
        'z-20! data-flux-sidebar-on-mobile:start-0! data-flux-sidebar-on-mobile:fixed! data-flux-sidebar-on-mobile:top-0! data-flux-sidebar-on-mobile:min-h-dvh! data-flux-sidebar-on-mobile:max-h-dvh!'
    ]);
}
@endphp

@if ($collapsibleOnMobile)
    <flux:sidebar.backdrop />
@endif

<ui-sidebar
    {{ $attributes->class($classes) }}
    @if ($collapsible) collapsible="{{ $collapsible === 'mobile' ? 'mobile' : 'true' }}" @endif
    @if ($stashable) stashable @endif
    @if ($sticky) sticky @endif
    x-data
    data-flux-sidebar-cloak
    data-flux-sidebar
>
    {{ $slot }}
</ui-sidebar>
