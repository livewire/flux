@blaze(fold: true)

@props([
    'code' => null,
    'language' => 'text',
    'copyable' => false,
    'highlight' => null,
])

@php
$source = $code ?? $slot->toHtml();
$source = str_replace(["\r\n", "\r"], "\n", $source);
$source = trim($source, "\n");

$classes = Flux::classes()
    ->add('relative overflow-hidden rounded-xl border border-zinc-200 dark:border-white/10')
    ->add('bg-zinc-50 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200')
    ->add('text-sm');

$contentClasses = Flux::classes()
    ->add('overflow-auto py-4 [scrollbar-width:thin]')
    ->add('[&_pre]:m-0 [&_pre]:min-w-max [&_pre]:bg-transparent!')
    ->add('[&_code]:block [&_code]:font-mono')
    ->add('[&_.line]:block [&_.line]:min-h-6 [&_.line]:px-4 [&_.line]:leading-6')
    ->add($copyable ? '[&_.line]:pr-14' : '')
    ->add('[&_.highlight]:border-l-2 [&_.highlight]:border-sky-400 [&_.highlight]:bg-sky-400/10 dark:[&_.highlight]:bg-sky-400/20')
    ->add('dark:[&_.shiki]:text-(--shiki-dark)! dark:[&_.shiki_span]:text-(--shiki-dark)!')
    ->add('dark:[&_.phiki]:text-(--phiki-dark-color)! dark:[&_.phiki_span]:text-(--phiki-dark-color)!')
    ->add('dark:[&_.shiki_span]:[font-style:var(--shiki-dark-font-style)]! dark:[&_.phiki_span]:[font-style:var(--phiki-dark-font-style)]!');
@endphp

<div
    {{ $attributes->class($classes) }}
    data-flux-code
    @if ($copyable)
        data-flux-code-source="{{ base64_encode($source) }}"
        x-data="fluxCode({ copied: @js(__('Code copied to clipboard')) })"
        x-bind:data-copied="copied || null"
    @endif
>
    @if ($copyable)
        <div class="absolute top-3 right-3 z-10">
            <flux:button
                type="button"
                variant="subtle"
                size="sm"
                square
                x-on:click="copy()"
                aria-label="{{ __('Copy code to clipboard') }}"
            >
                <flux:icon.clipboard-document variant="mini" class="[[data-copied]_&]:hidden" />
                <flux:icon.check variant="mini" class="hidden [[data-copied]_&]:block" />
            </flux:button>
        </div>

        <span class="sr-only" data-flux-code-status aria-live="polite" x-text="status"></span>
    @endif

    <div class="{{ $contentClasses }}" data-flux-code-content>
        {!! Flux::highlightCode($source, $language, $highlight) !!}
    </div>
</div>
