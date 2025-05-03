<?php

test('attributes can be ignored', function () {
    $flux = <<<'BLADE'
<flux:tests.ignored_attributes :$counter />
<flux:tests.ignored_attributes :$counter :wire:key="true" />
<flux:tests.ignored_attributes :$counter wire:key="true" />
<flux:tests.ignored_attributes :$counter wire:key="one" />
<flux:tests.ignored_attributes :$counter wire:key="two" />
BLADE;


    $counter = new \Flux\Tests\TestCounter;

    $expected = <<<'HTML'
<div></div><div wire:key=""></div><div wire:key="true"></div><div wire:key="one"></div><div wire:key="two"></div>
HTML;

    $this->assertSame($expected, $this->render($flux, ['counter' => $counter]));

    $this->assertSame(1, $counter->count);
});

test('attributes can be output in arbitrary places', function () {
    $flux = <<<'BLADE'
@foreach ($values as $value)
    <flux:tests.ignored_attributes_output :$value :$counter />
@endforeach
BLADE;

    $counter = new \Flux\Tests\TestCounter;

    $data = [
        'values' => [
            'one',
            'two',
            'three',
            'four',
            '<>',
        ],
        'counter' => $counter,
    ];

    $expected = <<<'HTML'
<div value="one">
    one
</div>    <div value="two">
    two
</div>    <div value="three">
    three
</div>    <div value="four">
    four
</div>    <div value="&lt;&gt;">
    &amp;lt;&amp;gt;
</div>
HTML;

    $this->assertSame($expected, $this->render($flux, $data));
    $this->assertSame(1, $counter->count);
});
