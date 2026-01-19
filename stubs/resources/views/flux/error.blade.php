@props([
    'icon' => 'exclamation-triangle',
    'bag' => 'default',
    'message' => null,
    'deep' => true,
    'nested' => true,
    'name' => null,
])

@php
$errorBag = $errors->getBag($bag);
$message ??= $name ? $errorBag->first($name) : null;

// Backwards compatibility...
if ($nested === false) {
    $deep = false;
}

if ($name && (is_null($message) || $message === '') && filter_var($deep, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== false) {
    $message = $errorBag->first($name . '.*');
}

$classes = Flux::classes('mt-3 text-sm font-medium text-red-500 dark:text-red-400')
    ->add($message ? '' : 'hidden');
@endphp

<div role="alert" aria-live="polite" aria-atomic="true" {{ $attributes->class($classes) }} data-flux-error>
    <?php if ($message) : ?>
        <?php if ($icon) : ?>
            <flux:icon :name="$icon" variant="mini" class="inline" />
        <?php endif; ?>

        {{ $message }}
    <?php endif; ?>
</div>
