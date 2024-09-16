@props([
    'variant' => 'default',
    'closable' => null,
    'title' => null,
    'name' => null,
])

@php
$closable ??= $variant === 'bare' ? false : true;

$classes = Flux::classes()
    ->add(match ($variant) {
        'default' => 'p-6 max-w-xl shadow-lg rounded-xl',
        'flyout' => 'fixed m-0 p-8 max-h-screen min-h-screen md:min-w-[25rem] overflow-y-auto ml-auto',
        'bare' => '',
    })
    ->add(match ($variant) {
        'default' => 'bg-white dark:bg-zinc-800 border border-transparent dark:border-zinc-700',
        'flyout' => 'bg-white dark:bg-zinc-800 border border-transparent dark:border-zinc-700',
        'bare' => 'bg-transparent',
    })
@endphp

<ui-modal {{ $attributes->except('class') }} data-flux-modal>
    <dialog
        wire:ignore.self {{-- This needs to be here because the dialog element adds a "close" attribute that isn't durable... --}}
        {{ $attributes->only('class')->class($classes) }}
        @if ($name) data-modal="{{ $name }}" @endif
        @if ($variant === 'flyout') data-flux-flyout @endif
        x-on:open-modal.document="if ($event.detail.name === @js($name)) $el.showModal()"
    >
        <?php if ($closable): ?>
            <div class="absolute top-0 right-0 mt-4 mr-4">
                <flux:modal.close>
                    <flux:button variant="ghost" icon="x-mark" size="sm" alt="Close modal" class="!text-zinc-400 hover:!text-zinc-800 dark:!text-zinc-500 dark:hover:!text-white"></flux:button>
                </flux:modal.close>
            </div>
        <?php endif; ?>

        {{ $slot }}
    </dialog>
</ui-modal>
