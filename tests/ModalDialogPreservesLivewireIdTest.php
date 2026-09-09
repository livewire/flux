<?php

/**
 * Regression: wire:click inside flux:modal must still resolve the Livewire
 * component that owns the modal after <dialog> enters the top layer.
 *
 * Livewire looks up the nearest [wire:id] from the click target. showModal()
 * (and dialog polyfills that move the node) leave the slot outside that
 * ancestor. The owner id is already passed into fluxModal(); it also has to
 * be stamped on the <dialog> itself, inside @unblaze so Blaze does not fold it.
 *
 * Livewire::test()->call() never hits this path — it invokes PHP directly.
 */

$stubPath = dirname(__DIR__).'/stubs/resources/views/flux/modal/index.blade.php';
$stub = file_get_contents($stubPath);

if ($stub === false) {
    fwrite(STDERR, "FAIL: unable to read modal stub\n");
    exit(1);
}

$failures = 0;

function assertTrue($condition, $message)
{
    global $failures;

    if ($condition) {
        fwrite(STDOUT, "PASS: {$message}\n");

        return;
    }

    fwrite(STDERR, "FAIL: {$message}\n");
    $failures++;
}

assertTrue(str_contains($stub, '<dialog'), 'modal stub renders a <dialog>');

assertTrue(
    (bool) preg_match('/@unblaze\b.*?@endunblaze/s', $stub, $unblazeMatch),
    'dialog Livewire id is inside @unblaze (not Blaze-folded)'
);

$unblaze = $unblazeMatch[0] ?? '';

assertTrue(
    str_contains($unblaze, 'wire:id="{{ $__livewire->getId() }}"'),
    '<dialog> stamps wire:id with the owning Livewire component id'
);

assertTrue(
    (bool) preg_match(
        '/if \(isset\(\$__livewire\)\):.*?wire:id="\{\{ \$__livewire->getId\(\) \}\}"/s',
        $unblaze
    ),
    'wire:id is omitted when the modal is rendered outside a Livewire component'
);

$dialogPos = strpos($stub, '<dialog');
$unblazePos = strpos($stub, '@unblaze');
$slotPos = strpos($stub, '{{ $slot }}');

assertTrue(
    $dialogPos !== false && $unblazePos !== false && $slotPos !== false
        && $dialogPos < $unblazePos && $unblazePos < $slotPos,
    'owner wire:id is on the <dialog>, which is what leaves the Livewire root'
);

exit($failures === 0 ? 0 : 1);
