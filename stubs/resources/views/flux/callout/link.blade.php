@pure

@props([
    'external' => null,
])

@php
$classes = Flux::classes()
    ->add('inline font-medium')
    ->add('underline underline-offset-[6px] hover:decoration-current')
    ->add('decoration-zinc-800/20 dark:decoration-white/20')
    ;
@endphp
{{-- NOTE: It's important that this file has NO newline at the end of the file. --}}
<a {{ $attributes->class($classes) }} <?php if ($external) : ?>target="_blank"<?php endif; ?>>{{ $slot }}</a>