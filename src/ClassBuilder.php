<?php

namespace Flux;

use Illuminate\Support\Arr;
use Stringable;

class ClassBuilder implements Stringable
{
    protected $pending = [];

    public function add($classes)
    {
        $clone = clone $this;
        
        $clone->pending[] = Arr::toCssClasses($classes);

        return $clone;
    }

    public function __toString()
    {
        return (string) collect($this->pending)->join(' ');
    }
}
