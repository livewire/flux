@props([
    'name' => null,
    'message' => null,
    'nested' => true,
])

@php
$message ??= $name ? $errors->first($name) : null;

if ((is_null($message) || $message === '') && $nested === true) {
    $message = $errors->first($name . '.*');
}

$classes = Flux::classes('mt-3 text-sm font-medium text-red-500 dark:text-red-400')
    ->add($message ? '' : 'hidden');
@endphp

<div role="alert" aria-live="polite" aria-atomic="true" {{ $attributes->class($classes) }} data-flux-error>
    <?php if ($message) : ?>
        <flux:icon icon="exclamation-triangle" variant="mini" class="inline" />

        {{ $message }}
    <?php endif; ?>
</div>
