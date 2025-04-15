<?php

test('components that do not have nocache regions are fully cached', function () {
    $flux = <<<'BLADE'
@for ($i = 0; $i < 2; $i++)
<flux:tests.full_cache>{{ $i }}|</flux:tests.full_cache>
@endfor
BLADE;

    $this->assertSame('0|0|', $this->render($flux));
});

test('attributes can bust the cache', function () {
    $flux = <<<'BLADE'
@for ($i = 0; $i < 2; $i++)
    <flux:tests.attribute_cache class="mt-2">{{ $i }}</flux:tests.attribute_cache>
    <flux:tests.attribute_cache class="mt-2">{{ $i }}</flux:tests.attribute_cache>
@endfor

<flux:tests.attribute_cache class="mt-2">i</flux:tests.attribute_cache>
<flux:tests.attribute_cache class="mt-2">i</flux:tests.attribute_cache>
<flux:tests.attribute_cache class="mt-3">i</flux:tests.attribute_cache>
<flux:tests.attribute_cache class="mt-3">i2</flux:tests.attribute_cache>
BLADE;

    $expected = <<<'HTML'
<div class="mt-2">0</div>    <div class="mt-2">0</div>    <div class="mt-2">0</div>    <div class="mt-2">0</div>
<div class="mt-2">0</div><div class="mt-2">0</div><div class="mt-3">i</div><div class="mt-3">i</div>
HTML;

    $this->assertSame($expected, $this->render($flux));
});

test('nocache directive with variables can exclude items from the cache', function () {
    $flux = <<<'BLADE'
@for ($i = 0; $i < 5; $i++)
<flux:tests.nocache_directive :value="$i">{{ $i }}</flux:tests.nocache_directive>
@endfor
BLADE;

    $expected = <<<'EXP'
The Value: 0
Slot: 0The Value: 1
Slot: 0The Value: 2
Slot: 0The Value: 3
Slot: 0The Value: 4
Slot: 0
EXP;

    $this->assertSame($expected, $this->render($flux));
});

test('nocache component with variables can exclude items from the cache', function () {
    $flux = <<<'BLADE'
@for ($i = 0; $i < 5; $i++)
<flux:tests.nocache_component_use :value="$i">{{ $i }}</flux:tests.nocache_component_use>
@endfor
BLADE;

    $expected = <<<'EXP'
The Value: 0
Slot: 0The Value: 1
Slot: 0The Value: 2
Slot: 0The Value: 3
Slot: 0The Value: 4
Slot: 0
EXP;

    $this->assertSame($expected, $this->render($flux));
});

test('nocache can be applied to slot contents', function () {
    $flux = <<<'BLADE'
@for ($i = 0; $i < 3; $i++)
<flux:tests.nocache_slot :$counter>Slot: {{ $i }}</flux:tests.nocache_slot>
@endfor
BLADE;

    $counter = new \Flux\Tests\TestCounter;

    $result = $this->render($flux, ['counter' => $counter]);

    $this->assertSame(1, $counter->count);
    $this->assertSame('Slot: 0Slot: 0Slot: 0', $result);
});

test('nocache can be applied to named slots', function () {
    $flux = <<<'BLADE'
<flux:tests.nocache_named_slot :$counter icon="bell" />
<flux:tests.nocache_named_slot :$counter>
    <x-slot name="icon">A slot!</x-slot>
</flux:tests.nocache_named_slot>

<flux:tests.nocache_named_slot :$counter>
    <x-slot name="icon">Another slot!</x-slot>
</flux:tests.nocache_named_slot>
BLADE;

    $counter = new \Flux\Tests\TestCounter;

    $result = $this->render($flux, ['counter' => $counter]);

    $this->assertSame(2, $counter->count);

    $this->assertStringContainsString('Was just a prop: bell', $result);
    $this->assertStringContainsString('A slot!', $result);
    $this->assertStringContainsString('Another slot!', $result);
});

test('multiple nocache regions can be declared', function () {
    $flux = <<<'BLADE'
@for ($i = 0; $i < 3; $i++)
<flux:tests.multiple_nocache :$counter>Slot 1: {{ $i }}</flux:tests.multiple_nocache>
<flux:tests.multiple_nocache :$counter value="value-{{ $i }}">Slot 2: {{ $i }}</flux:tests.multiple_nocache>
@endfor
BLADE;

    $counter = new \Flux\Tests\TestCounter;

    $result = $this->render($flux, ['counter' => $counter]);

    $expected = <<<'HTML'
<option
    
        
>Slot 1: 0</option><option
    
     value="value-0"      wire:key="value-0" 
>Slot 2: 0</option><option
    
        
>Slot 1: 1</option><option
    
     value="value-1"      wire:key="value-1" 
>Slot 2: 1</option><option
    
        
>Slot 1: 2</option><option
    
     value="value-2"      wire:key="value-2" 
>Slot 2: 2</option>
HTML;

    $this->assertSame($expected, $result);
    $this->assertSame(1, $counter->count);
});

test('inner components do not force caching of wrapper components', function () {
    $flux = <<<'BLADE'
@for ($i = 0; $i < 10; $i++)
<flux:tests.wrapper :counter="$wrapperCounter">
    <flux:tests.wrapper_inner :counter="$innerCounter">|{{ $i }}</flux:tests.wrapper_inner>
</flux:tests.wrapper>
@endfor
BLADE;

    $wrapperCounter = new \Flux\Tests\TestCounter;
    $innerCounter = new \Flux\Tests\TestCounter;

    $result = $this->render($flux, [
        'wrapperCounter' => $wrapperCounter,
        'innerCounter' => $innerCounter,
    ]);

    $this->assertStringContainsString('|9', $result);
    $this->assertSame(1, $innerCounter->count);
    $this->assertSame(10, $wrapperCounter->count);
});
