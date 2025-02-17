@props([
    'sticky' => null,
])

@php
$classes = Flux::classes('[grid-area:aside]');

if ($sticky) {
    $attributes = $attributes->merge([
        'x-data' => '',
        'x-bind:style' => '{ position: \'sticky\', top: $el.offsetTop + \'px\', \'max-height\': \'calc(100dvh - \' + $el.offsetTop + \'px)\' }',
        'class' => 'max-h-[100vh] overflow-y-auto',
    ]);
}
@endphp

<div {{ $attributes->class($classes) }} data-flux-aside>
    {{ $slot }}
</div>
