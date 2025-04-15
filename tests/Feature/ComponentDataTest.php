<?php

test('methods passed as attribute values do not get invoked excessively', function () {
    // This test ensures that the $component->withAttributes([...]) does not call our methods twice.

    $flux = <<<'BLADE'
<flux:tests.default_slot count="{{ $counter->increment() }}">The Content</flux:tests.default_slot>
BLADE;

    $counter = new \Flux\Tests\TestCounter;

    $result = $this->render($flux, ['counter' => $counter]);

    $this->assertSame(1, $counter->count);
    $this->assertSame(
        '<div count="1">The Content</div>',
        $result
    );
});
