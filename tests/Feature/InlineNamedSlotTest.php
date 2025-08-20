<?php

test('inline flux slots are rendered', function () {
    $flux = <<<'BLADE'
<flux:tests.named_slots>
    <flux:tests.component_a slot="header" />
    <flux:tests.component_b slot="footer" />  
    
    Main Content
</flux:tests.named_slots>
BLADE;

    $expected = <<<'HTML'
<header >Component A Content</header>
<article >Main Content</article>
<footer >Component B Content</footer>
HTML;

    $this->assertSame($expected, $this->render($flux));
});
