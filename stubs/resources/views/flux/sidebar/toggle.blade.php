@pure

<flux:button
    :attributes="$attributes->merge([
        'class' => 'shrink-0',
        'variant' => 'subtle',
    ])"
    square
    x-data
    x-on:click="document.querySelector('ui-sidebar').toggle()"
    data-flux-sidebar-toggle
    aria-label="{{ __('Toggle sidebar') }}"
/>
