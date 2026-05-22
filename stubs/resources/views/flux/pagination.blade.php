@blaze(fold: true)

<?php
// Workaround: when `scroll-to` is forwarded via `:attributes` (e.g. from the table component
// using `attributesAfter`), Laravel doesn't convert the kebab-case `scroll-to` attribute to
// the camelCase `scrollTo` prop. `forwardedAttributes` handles this conversion manually.
extract(Flux::forwardedAttributes($attributes, ['scrollTo']));
?>

@props([
    'paginator' => null,
    'scrollTo' => $scrollTo ?? null,
])

@php
$simple = ! $paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;

$scrollToSelector = $scrollTo === true ? 'body' : $scrollTo;

$scrollIntoViewJsSnippet = ($scrollTo !== null && $scrollTo !== false)
    ? "(\$el.closest('{$scrollToSelector}') || \$el.closest('body').querySelector('{$scrollToSelector}')).scrollIntoView()"
    : '';
@endphp

<?php if ($simple): ?>
    <div {{ $attributes->class('pt-3 border-t border-zinc-100 dark:border-zinc-700 flex justify-between items-center') }} data-flux-pagination>
        <div></div>

        <?php if ($paginator->hasPages()): ?>
            <div class="flex items-center bg-white border border-zinc-200 rounded-[8px] p-[1px] dark:bg-white/10 dark:border-white/10">
                <?php if ($paginator->onFirstPage()): ?>
                    <div class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <flux:icon.chevron-left variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-right variant="micro" class="hidden rtl:inline" />
                    </div>
                <?php else: ?>
                    <?php if (method_exists($paginator,'getCursorName')): ?>
                        <button type="button" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-left variant="micro" class="rtl:hidden" />
                            <flux:icon.chevron-right variant="micro" class="hidden rtl:inline" />
                        </button>
                    <?php else: ?>
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-left variant="micro" class="rtl:hidden" />
                            <flux:icon.chevron-right variant="micro" class="hidden rtl:inline" />
                        </button>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (($paginator->hasMorePages())): ?>
                    <?php if ((method_exists($paginator, 'getCursorName'))): ?>
                        <button type="button" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-right variant="micro" class="rtl:hidden" />
                            <flux:icon.chevron-left variant="micro" class="hidden rtl:inline" />
                        </button>
                    <?php else: ?>
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-white hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                            <flux:icon.chevron-right variant="micro" class="rtl:hidden" />
                            <flux:icon.chevron-left variant="micro" class="hidden rtl:inline" />
                        </button>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <flux:icon.chevron-right variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-left variant="micro" class="hidden rtl:inline" />
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div {{ $attributes->class('@container pt-3 border-t border-zinc-100 dark:border-zinc-700 flex justify-between items-center gap-3') }} data-flux-pagination>
        <?php if (($paginator->total() > 0)): ?>
            <div class="text-zinc-500 dark:text-zinc-400 text-xs font-medium whitespace-nowrap">
                {!! __('Showing') !!} {{ $paginator->firstItem() }} {!! __('to') !!} {{ $paginator->lastItem() }} {!! __('of') !!} {{ $paginator->total() }} {!! __('results') !!}
            </div>
        <?php else: ?>
            <div></div>
        <?php endif; ?>

        <?php if (($paginator->hasPages())): ?>
            {{-- Mobile pagination --}}
            <div class="flex @[40rem]:hidden items-center bg-white border border-zinc-200 rounded-[8px] p-[1px] dark:bg-white/10 dark:border-white/10">
                <?php if (($paginator->onFirstPage())): ?>
                    <div aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <flux:icon.chevron-left variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-right variant="micro" class="hidden rtl:inline" />
                    </div>
                <?php else: ?>
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" aria-label="{{ __('pagination.previous') }}" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                        <flux:icon.chevron-left variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-right variant="micro" class="hidden rtl:inline" />
                    </button>
                <?php endif; ?>

                <?php if (($paginator->hasMorePages())): ?>
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" aria-label="{{ __('pagination.next') }}" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                        <flux:icon.chevron-right variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-left variant="micro" class="hidden rtl:inline" />
                    </button>
                <?php else: ?>
                    <div aria-label="{{ __('pagination.next') }}" class="flex justify-center items-center size-8 sm:size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <flux:icon.chevron-right variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-left variant="micro" class="hidden rtl:inline" />
                    </div>
                <?php endif; ?>
            </div>

            {{-- Desktop pagination --}}
            <div class="hidden @[40rem]:flex items-center bg-white border border-zinc-200 rounded-[8px] p-[1px] dark:bg-white/10 dark:border-white/10">
                <?php if ($paginator->onFirstPage()): ?>
                    <div aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <flux:icon.chevron-left variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-right variant="micro" class="hidden rtl:inline" />
                    </div>
                <?php else: ?>
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" aria-label="{{ __('pagination.previous') }}" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                        <flux:icon.chevron-left variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-right variant="micro" class="hidden rtl:inline" />
                    </button>
                <?php endif; ?>

                <?php foreach (\Livewire\invade($paginator)->elements() as $element): ?>
                    {{-- "Three Dots" Separator --}}
                    <?php if (is_string($element)): ?>
                        <div
                            aria-disabled="true"
                            class="cursor-default flex justify-center items-center text-xs size-6 rounded-[6px] font-medium dark:text-zinc-400 text-zinc-400"
                        >{{ $element }}</div>
                    <?php endif; ?>

                    {{-- Array Of Links --}}
                    <?php if (is_array($element)): ?>
                        <?php foreach ($element as $page => $url): ?>
                            <?php if ($page == $paginator->currentPage()): ?>
                                <div
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}"
                                    aria-current="page"
                                    class="cursor-default flex justify-center items-center text-xs h-6 px-2 rounded-[6px] font-medium dark:text-white text-zinc-800"
                                >{{ $page }}</div>
                            <?php else: ?>
                                <button
                                    wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}"
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    type="button"
                                    class="text-xs h-6 px-2 rounded-[6px] text-zinc-400 font-medium dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white"
                                >{{ $page }}</button>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($paginator->hasMorePages()): ?>
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" aria-label="{{ __('pagination.next') }}" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                        <flux:icon.chevron-right variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-left variant="micro" class="hidden rtl:inline" />
                    </button>
                <?php else: ?>
                    <div aria-label="{{ __('pagination.next') }}" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <flux:icon.chevron-right variant="micro" class="rtl:hidden" />
                        <flux:icon.chevron-left variant="micro" class="hidden rtl:inline" />
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
