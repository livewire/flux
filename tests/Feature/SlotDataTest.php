<?php

test('flux slot components receive component instance', function () {
    $flux = <<<'BLADE'
<flux:tests.default_slot>
    Component: {{ $component->componentName }}
</flux:tests.default_slot>
BLADE;

    $this->assertSame(
        '<div >Component: flux::tests.default_slot</div>',
        $this->render($flux)
    );
});

test('named slots receive component instance', function () {
    $blade = <<<'BLADE'
<flux:tests.named_slots>
    <x-slot:header>{{ $component->componentName }}</x-slot:header>
    <x-slot:footer>{{ $component->componentName }}</x-slot:footer>
    
    {{ $component->componentName }}
</flux:tests.named_slots>
BLADE;

    $expected = <<<'HTML'
<header >flux::tests.named_slots</header>
<article >flux::tests.named_slots</article>
<footer >flux::tests.named_slots</footer>
HTML;

    $this->assertSame($expected, $this->render($blade));
});

test('slot content is not retained across multiple renders', function () {
    $flux = <<<'BLADE'
@for ($i = 0; $i < 3; $i++)
<flux:tests.default_slot>Render: {{ $i }}</flux:tests.default_slot>
@endfor
BLADE;

    $this->assertSame(
        '<div >Render: 0</div><div >Render: 1</div><div >Render: 2</div>',
        $this->render($flux)
    );
});
