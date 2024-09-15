<?php

namespace Flux;

use Illuminate\Support\Arr;
use Stringable;

class ClassBuilder implements Stringable
{
    protected $pending = [];

    public function add($classes)
    {
        $this->pending[] = Arr::toCssClasses($classes);

        return $this;
    }

    public function __toString()
    {
        return (string) collect($this->pending)->join(' ');
    }
}
