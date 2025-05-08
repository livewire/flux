@cached

@setup
@props(['title'])
@endsetup

<flux:uncached>
Title: {{ $title ?? 'nope' }}
Attributes: {{ $attributes }}
</flux:uncached>