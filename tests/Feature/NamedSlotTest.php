<?php

use Illuminate\Support\Str;

test('named slots are rendered with flux components', function () {
    $blade = <<<'BLADE'
<flux:tests.named_slots>
    <x-slot:header>The Header Content</x-slot:header>
    <x-slot:footer>The Footer Content</x-slot:footer>
    
    The Main Content
</flux:tests.named_slots>
BLADE;

    $expected = <<<'HTML'
<header >The Header Content</header>
<article >The Main Content</article>
<footer >The Footer Content</footer>
HTML;

    $this->assertSame($expected, $this->render($blade));
});

test('attribute bags are applied to named slots', function () {
    $flux = <<<'BLADE'
<flux:tests.named_slots class="article-class">
    <x-slot:header class="header-class">The Header Content</x-slot:header>
    <x-slot:footer class="footer-class">The Footer Content</x-slot:footer>
    
    The Main Content
</flux:tests.named_slots>
BLADE;

    $expected = <<<'HTML'
<header class="header-class">The Header Content</header>
<article class="article-class">The Main Content</article>
<footer class="footer-class">The Footer Content</footer>
HTML;

    $this->assertSame($expected, $this->render($flux));
});

test('blade named slot behavior', function () {
    $blade = <<<'BLADE'
<x-named_slots>
    Leading Content

    <x-slot:header class="header-class">The Header Content</x-slot:header>
    
    Middle Content
    
    <x-slot:footer class="footer-class">The Footer Content</x-slot:footer>
    
    Trailing Content
</x-named_slots>
BLADE;

    $flux = <<<'BLADE'
<flux:tests.named_slots>
    Leading Content

    <x-slot:header class="header-class">The Header Content</x-slot:header>
    
    Middle Content
    
    <x-slot:footer class="footer-class">The Footer Content</x-slot:footer>
    
    Trailing Content
</flux:tests.named_slots>
BLADE;

    // Using squish to normalize the whitespace left by the Blade compiler.
    $actualFlux = Str::squish($this->render($flux));
    $actualBlade = Str::squish($this->render($blade));

    $this->assertStringContainsString('Leading Content', $actualFlux);
    $this->assertStringContainsString('Middle Content', $actualFlux);
    $this->assertStringContainsString('Trailing Content', $actualFlux);

    $this->assertStringContainsString('<footer class="footer-class">The Footer Content</footer>', $actualFlux);
    $this->assertStringContainsString('<header class="header-class">The Header Content</header>', $actualFlux);

    $this->assertSame($actualBlade, $actualFlux);
});

test('nested component slots with similarly named named slots do not get confused', function () {
    $flux = <<<'BLADE'
<flux:tests.named_slots>
    <x-slot:header>
        Start of Inner Header #1

        <flux:tests.named_slots>
            <x-slot:header>Header: Inner Header Slot #1</x-slot:header>
            <x-slot:footer>Header: Inner Footer Slot #1</x-slot:footer>
            
            Start of Inner Nested Content
            <flux:tests.named_slots>
                <x-slot:header>Header: Inner Header Slot #2</x-slot:header>
                <x-slot:footer>Header: Inner Footer Slot #2</x-slot:footer>
                
                Start of Inner Nested Content #2!
                <flux:tests.named_slots>
                    <x-slot:header>Header: Inner Header Slot #3</x-slot:header>
                    <x-slot:footer>Header: Inner Footer Slot #3</x-slot:footer>
                    
                    Inner Header Content #3
                </flux:tests.named_slots>
            </flux:tests.named_slots>
            
            End of Inner Nested Content
        </flux:tests.named_slots>
        
        End of Inner Header # 1
    </x-slot:header>
    
    <x-slot:footer>
        Start of Inner Footer #4

        <flux:tests.named_slots>
            <x-slot:header>Footer: Inner Header Slot #4</x-slot:header>
            <x-slot:footer>Footer: Inner Footer Slot #4</x-slot:footer>
            
            Inner Footer Content #4
        </flux:tests.named_slots>
        
        End of Inner Footer
    </x-slot:footer>

    Main Content
</flux:tests.named_slots>
BLADE;

    $expected = <<<'HTML'
<header >Start of Inner Header #1

        <header >Header: Inner Header Slot #1</header>
<article >Start of Inner Nested Content
            <header >Header: Inner Header Slot #2</header>
<article >Start of Inner Nested Content #2!
                <header >Header: Inner Header Slot #3</header>
<article >Inner Header Content #3</article>
<footer >Header: Inner Footer Slot #3</footer></article>
<footer >Header: Inner Footer Slot #2</footer>            
            End of Inner Nested Content</article>
<footer >Header: Inner Footer Slot #1</footer>        
        End of Inner Header # 1</header>
<article >Main Content</article>
<footer >Start of Inner Footer #4

        <header >Footer: Inner Header Slot #4</header>
<article >Inner Footer Content #4</article>
<footer >Footer: Inner Footer Slot #4</footer>        
        End of Inner Footer</footer>
HTML;

    $this->assertSame($expected, $this->render($flux));
});
