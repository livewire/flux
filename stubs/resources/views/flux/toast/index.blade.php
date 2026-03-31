@blaze(fold: true, safe: ['position'])

@props([
    'position' => 'bottom end',
    'variant' => 'outline'
])

@php
    $classes = Flux::classes('p-2 flex rounded-xl shadow-lg border')
        ->add('border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-700 border-b-zinc-300/80')
        ->add($variant === 'primary' ? [
            // Info variant
            '[[data-flux-toast-dialog][data-variant=info]_&]:bg-cyan-600',
            '[[data-flux-toast-dialog][data-variant=info]_&]:dark:bg-cyan-500',
            '[[data-flux-toast-dialog][data-variant=info]_&]:border-cyan-600',
            '[[data-flux-toast-dialog][data-variant=info]_&]:dark:border-cyan-500',
            '[[data-flux-toast-dialog][data-variant=info]_&]:in-[ui-toast-group[position^="top"]:not([expanded]):not(:hover)]:border-b-cyan-500/80',
            '[[data-flux-toast-dialog][data-variant=info]_&]:in-[ui-toast-group[position^="bottom"]:not([expanded]):not(:hover)]:border-t-cyan-500/80',

            // Success variant
            '[[data-flux-toast-dialog][data-variant=success]_&]:bg-lime-600',
            '[[data-flux-toast-dialog][data-variant=success]_&]:dark:bg-lime-500',
            '[[data-flux-toast-dialog][data-variant=success]_&]:border-lime-600',
            '[[data-flux-toast-dialog][data-variant=success]_&]:dark:border-lime-500',
            '[[data-flux-toast-dialog][data-variant=success]_&]:in-[ui-toast-group[position^="top"]:not([expanded]):not(:hover)]:border-b-lime-500/40',
            '[[data-flux-toast-dialog][data-variant=success]_&]:in-[ui-toast-group[position^="bottom"]:not([expanded]):not(:hover)]:border-t-lime-500',
            '[[data-flux-toast-dialog][data-variant=success]_&]:dark:in-[ui-toast-group[position^="top"]:not([expanded]):not(:hover)]:border-b-lime-400/40',
            '[[data-flux-toast-dialog][data-variant=success]_&]:dark:in-[ui-toast-group[position^="bottom"]:not([expanded]):not(:hover)]:border-t-lime-300/80',

            // Warning variant
            '[[data-flux-toast-dialog][data-variant=warning]_&]:bg-amber-300',
            '[[data-flux-toast-dialog][data-variant=warning]_&]:border-amber-300',
            '[[data-flux-toast-dialog][data-variant=warning]_&]:in-[ui-toast-group[position^="top"]:not([expanded]):not(:hover)]:border-b-amber-200/40',
            '[[data-flux-toast-dialog][data-variant=warning]_&]:in-[ui-toast-group[position^="bottom"]:not([expanded]):not(:hover)]:border-t-amber-400',

            // Danger variant
            '[[data-flux-toast-dialog][data-variant=danger]_&]:bg-rose-600',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:dark:bg-rose-500',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:border-rose-600',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:dark:border-rose-500',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:in-[ui-toast-group[position^="top"]:not([expanded]):not(:hover)]:border-b-rose-400/60',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:in-[ui-toast-group[position^="bottom"]:not([expanded]):not(:hover)]:border-t-rose-400/60',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:dark:in-[ui-toast-group[position^="top"]:not([expanded]):not(:hover)]:border-b-rose-400/80',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:dark:in-[ui-toast-group[position^="bottom"]:not([expanded]):not(:hover)]:border-t-rose-400/80',
        ] : '');

    $headingClasses = Flux::classes('font-medium text-sm text-zinc-800 dark:text-white [&:not(:empty)+div]:font-normal [&:not(:empty)+div]:text-zinc-500 [&:not(:empty)+div]:dark:text-zinc-300 not-empty:pb-2')
        ->add($variant === 'primary' ? [
            '[[data-flux-toast-dialog]:is([data-variant=success],[data-variant=info],[data-variant=danger])_&]:text-white',
            '[[data-flux-toast-dialog][data-variant=warning]_&]:text-amber-950',
        ] : '');

    $textClasses = Flux::classes('font-medium text-sm text-zinc-800 dark:text-white')
        ->add($variant === 'primary' ? [
            '[[data-flux-toast-dialog]:is([data-variant=success],[data-variant=info],[data-variant=danger])_&]:text-white',
            '[[data-flux-toast-dialog][data-variant=warning]_&]:text-amber-950',
        ] : '');

    $closeButtonClasses = Flux::classes('inline-flex items-center justify-center gap-2 font-medium truncate h-8 w-8 text-sm rounded-md bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-400 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white disabled:opacity-50 dark:disabled:opacity-75 disabled:cursor-default')
        ->add($variant === 'primary' ? [
            '[[data-flux-toast-dialog]:is([data-variant=success],[data-variant=info],[data-variant=danger])_&]:text-white',
            '[[data-flux-toast-dialog][data-variant=warning]_&]:text-amber-950',
            '[[data-flux-toast-dialog][data-variant=info]_&]:hover:bg-cyan-500',
            '[[data-flux-toast-dialog][data-variant=info]_&]:dark:hover:bg-cyan-400',
            '[[data-flux-toast-dialog][data-variant=success]_&]:hover:bg-lime-500',
            '[[data-flux-toast-dialog][data-variant=success]_&]:dark:hover:bg-lime-400',
            '[[data-flux-toast-dialog][data-variant=warning]_&]:hover:bg-amber-200/80',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:hover:bg-rose-500',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:dark:hover:bg-rose-400',
            '[[data-flux-toast-dialog][data-variant=danger]_&]:hover:text-white',
        ] : '');
@endphp

<ui-toast x-data x-on:toast-show.document="! $el.closest('ui-toast-group') && $el.showToast($event.detail)" popover="manual" position="{{ $position }}" wire:ignore>
    <template>
        <div {{ $attributes->only(['class'])->class('max-w-sm in-[ui-toast-group]:max-w-auto in-[ui-toast-group]:w-xs sm:in-[ui-toast-group]:w-sm') }} data-variant="" data-flux-toast-dialog>
            <div class="{{ $classes }}">
                <div class="flex-1 flex items-start gap-4 overflow-hidden">
                    <div class="flex-1 py-1.5 ps-2.5 flex gap-2">
                        {{-- Success icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=success]_&]:block shrink-0 mt-0.5 size-4 {{ $variant === 'primary' ? 'text-white' : 'text-lime-600 dark:text-lime-400' }}">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                        </svg>

                        {{-- Warning icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=warning]_&]:block shrink-0 mt-0.5 size-4 {{ $variant === 'primary' ? 'text-amber-950' : 'text-amber-500 dark:text-amber-400' }}">
                            <path fill-rule="evenodd" d="M6.701 2.25c.577-1 2.02-1 2.598 0l5.196 9a1.5 1.5 0 0 1-1.299 2.25H2.804a1.5 1.5 0 0 1-1.3-2.25l5.197-9ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 1 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>

                        {{-- Info icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=info]_&]:block shrink-0 mt-0.5 size-4 {{ $variant === 'primary' ? 'text-white' : 'text-cyan-500 dark:text-cyan-400' }}">
                            <path fill-rule="evenodd" d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM9 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM6.75 8a.75.75 0 0 0 0 1.5h.75v1.75a.75.75 0 0 0 1.5 0v-2.5A.75.75 0 0 0 8.25 8h-1.5Z" clip-rule="evenodd" />
                        </svg>

                        {{-- Danger icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=danger]_&]:block shrink-0 mt-0.5 size-4 {{ $variant === 'primary' ? 'text-white' : 'text-rose-500 dark:text-rose-400' }}">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>

                        <div>
                            {{-- Heading --}}
                            <div class="{{ $headingClasses }}"><slot name="heading"></slot></div>

                            {{-- Text --}}
                            <div class="{{ $textClasses }}"><slot name="text"></slot></div>
                        </div>
                    </div>

                    {{-- Close button --}}
                    <ui-close class="flex items-center">
                        <button type="button" class="{{ $closeButtonClasses }}" as="button">
                            <div>
                                <svg class="[:where(&)]:size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"></path>
                                </svg>
                            </div>
                        </button>
                    </ui-close>
                </div>
            </div>
        </div>
    </template>
</ui-toast>