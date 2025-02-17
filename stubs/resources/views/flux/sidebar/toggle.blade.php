
<flux:button
    :attributes="$attributes->merge([
        'class' => 'shrink-0',
        'variant' => 'subtle',
    ])"
    square
    x-data
    x-on:click="document.body.hasAttribute('data-show-stashed-sidebar') ? document.body.removeAttribute('data-show-stashed-sidebar') : document.body.setAttribute('data-show-stashed-sidebar', '')"
    data-flux-sidebar-toggle
    aria-label="{{ __('Toggle sidebar') }}"
/>
