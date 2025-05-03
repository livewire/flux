<?php

test('simple flux components are rendered', function () {
    $this->assertSame(
        'Simple Output',
        $this->render('<flux:tests.simple />'),
        'Colon: Self closing tag'
    );

    $this->assertSame(
        'Simple Output',
        $this->render('<flux:tests.simple></flux:tests.simple>'),
        'Colon: Tag pair without slot contents'
    );

    $this->assertSame(
        'Simple Output',
        $this->render('<flux:tests.simple> </flux:tests.simple>'),
        'Colon: Tag pair with useless slot content'
    );
});

test('flux component whitespace behavior matches blade', function () {
    $flux = <<<'BLADE'
<flux:tests.default_slot>

The Slot Contents

</flux:tests.default_slot>
BLADE;

    $blade = <<<'BLADE'
<flux:tests.default_slot>

The Slot Contents

</flux:tests.default_slot>
BLADE;

    $this->assertSame($this->render($blade), $this->render($flux));
});

test('escaped blade is preserved', function () {
    $flux = <<<'BLADE'
<flux:tests.default_slot variant="strong">$@{{ $i }}.00</flux:tests.default_slot>
BLADE;

    $this->assertSame('<div variant="strong">${{ $i }}.00</div>', $this->render($flux));
});

test('literal replacements are not replaced', function () {
    // Excessive nesting is to ensure that are not
    // incorrectly applied to nested buffers
    $flux = <<<'BLADE'
<flux:tests.default_slot>
start:a
<flux:tests.default_slot>
start:b
<flux:tests.default_slot>
start:c
<flux:tests.default_slot>
inner: {{ $title }}
</flux:tests.default_slot>
end:c
</flux:tests.default_slot>
end:b
</flux:tests.default_slot>
end:a
</flux:tests.default_slot>
BLADE;

    $expected = <<<'HTML'
<div >start:a
<div >start:b
<div >start:c
<div >inner: The Title</div>end:c</div>end:b</div>end:a</div>
HTML;

    $this->assertSame($expected, $this->render($flux, ['title' => 'The Title']));
});

test('optimized components do not add extra newlines at the end', function () {
    $flux = <<<'BLADE'
<flux:tests.optimized_props title="The Title" class="mt-4" />
BLADE;

    $expected = <<<'HTML'
Title: The Title
Attributes: class="mt-4"
HTML;

    $this->assertSame($expected, $this->render($flux));
});
