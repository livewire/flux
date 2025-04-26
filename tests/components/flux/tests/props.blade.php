@cached

@props(['title'])

<flux:nocache>
Title: {{ $title ?? 'nope' }}
Attributes: {{ $attributes }}
</flux:nocache>