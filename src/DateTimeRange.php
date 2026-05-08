<?php

namespace Flux;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DateTimeRange extends CarbonPeriod
{
    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);
    }

    public function start(): ?Carbon
    {
        return $this->getStartDate();
    }

    public function end(): ?Carbon
    {
        return $this->getEndDate();
    }

    public function hasStart(): bool
    {
        return $this->getStartDate() !== null;
    }

    public function hasEnd(): bool
    {
        return $this->getEndDate() !== null;
    }
}
