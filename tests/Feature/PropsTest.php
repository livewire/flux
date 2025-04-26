<?php

test('props can be used on cached instances', function () {
    $flux = <<<'BLADE'
<flux:tests.props title="Title 1" class="mt-1 mt-2"></flux:tests.props>
<flux:tests.props title="Title 2" class="mt-1 mt-2"></flux:tests.props>
BLADE;

    $expected = <<<'EXPECTED'
Title: Title 1
Attributes: class="mt-1 mt-2"
Title: Title 2
Attributes: class="mt-1 mt-2"

EXPECTED;

    $this->assertSame($expected, $this->render($flux));

    // Ensure props are still available after things have been cached once.
    $this->assertSame($expected, $this->render($flux));
    $this->assertSame($expected, $this->render($flux));
});