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
    ->add('relative overflow-hidden rounded-2xl border')
    ->add('[:where(&)]:border-zinc-200 dark:[:where(&)]:border-white/10')
    ->add('[:where(&)]:bg-zinc-50 dark:[:where(&)]:bg-zinc-800 text-zinc-800 dark:text-zinc-200')
    ->add('text-sm');

$contentClasses = Flux::classes()
    ->add('overflow-auto py-5 [scrollbar-width:thin]')
    ->add('[&_pre]:m-0 [&_pre]:min-w-max [&_pre]:bg-transparent!')
    ->add('[&_code]:block [&_code]:font-mono')
    ->add('[&_.line]:block [&_.line]:min-h-[2em] [&_.line]:pl-5 [&_.line]:leading-[2]')
    ->add($copyable ? '[&_.line]:pr-12' : '[&_.line]:pr-5')
    ->add('[&_.highlight]:empty:opacity-0')
    ->add('[&_.diff]:empty:opacity-0')
    ->add('[&_.highlight-line]:border-l-2 [&_.highlight-line]:border-sky-400 [&_.highlight-line]:bg-sky-400/10 dark:[&_.highlight-line]:bg-sky-400/20')
    ->add('[&_.highlight-characters]:isolate [&_.highlight-characters]:relative')
    ->add('[&_.highlight-characters]:before:absolute [&_.highlight-characters]:before:-z-10 [&_.highlight-characters]:before:inset-y-0 [&_.highlight-characters]:before:inset-x-[-2px]')
    ->add('[&_.highlight-characters]:before:border-r-2 [&_.highlight-characters]:before:border-sky-400 [&_.highlight-characters]:before:bg-sky-400/10 dark:[&_.highlight-characters]:before:bg-sky-400/20')
    ->add('[&_.diff-added]:border-l-2 [&_.diff-added]:border-emerald-400 [&_.diff-added]:bg-emerald-400/10 dark:[&_.diff-added]:bg-emerald-400/20')
    ->add('[&_.diff-removed]:border-l-2 [&_.diff-removed]:border-red-400 [&_.diff-removed]:bg-red-400/10 dark:[&_.diff-removed]:bg-red-400/20')
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
        <div class="absolute top-0 right-0 pt-3 pr-3 z-10">
            <flux:button
                type="button"
                size="sm"
                square
                x-on:click="copy()"
                tooltip="{{ __('Copy to clipboard') }}"
                aria-label="{{ __('Copy code to clipboard') }}"
            >
                <flux:icon.clipboard-document variant="mini" class="[[data-copied]_&]:hidden size-5! text-gray-400 dark:text-gray-300" />
                <flux:icon.check variant="mini" class="hidden [[data-copied]_&]:block size-5!" />
            </flux:button>
        </div>

        <span class="sr-only" data-flux-code-status aria-live="polite" x-text="status"></span>
    @endif

    <div class="{{ $contentClasses }}" data-flux-code-content>
        {!! Flux::highlightCode($source, $language, $highlight) !!}
    </div>
</div>
