@cached(['except' => 'value'])

@props(['counter'])

@php($counter->increment())

<div {{ $attributes }}>
    {{ $attributes->get('value') }}
</div>