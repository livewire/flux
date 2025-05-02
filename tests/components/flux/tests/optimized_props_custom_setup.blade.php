@optimized

<flux:setup>
    @props(['title'])
</flux:setup>

Title: {{ $title ?? 'nope' }}
Attributes: {{ $attributes }}