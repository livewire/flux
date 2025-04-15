<?php

namespace Flux\Tests;

class TestCounter
{
    public $count = 0;

    public function increment()
    {
        return ++$this->count;
    }
}