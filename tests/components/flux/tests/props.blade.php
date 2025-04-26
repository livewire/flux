@cached

@props(['title'])

<flux:uncached>
Title: {{ $title ?? 'nope' }}
Attributes: {{ $attributes }}
</flux:uncached>