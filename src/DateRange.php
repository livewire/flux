<?php

namespace Flux;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DateRange extends CarbonPeriod
{
    protected $preset;

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

    public function preset(): ?DateRangePreset
    {
        return $this->preset;
    }

    public function hasStart(): bool
    {
        return $this->getStartDate() !== null;
    }

    public function hasEnd(): bool
    {
        return $this->getEndDate() !== null;
    }

    public function hasPreset(): bool
    {
        return $this->preset !== null;
    }

    public function isNotAllTime(): bool
    {
        return $this->preset !== DateRangePreset::AllTime;
    }

    protected static function fromPreset(DateRangePreset $preset)
    {
        if ($preset === DateRangePreset::AllTime) {
            throw new \Exception('All time date range is not supported via this constructor because it requires a start date. Please use the ::allTime($start) constructor instead.');
        }

        $instance = new static(...$preset->dates());

        $instance->preset = $preset;

        return $instance;
    }

    public static function today() { return static::fromPreset(DateRangePreset::Today); }
    public static function yesterday() { return static::fromPreset(DateRangePreset::Yesterday); }
    public static function thisWeek() { return static::fromPreset(DateRangePreset::ThisWeek); }
    public static function lastWeek() { return static::fromPreset(DateRangePreset::LastWeek); }
    public static function last7Days() { return static::fromPreset(DateRangePreset::Last7Days); }
    public static function thisMonth() { return static::fromPreset(DateRangePreset::ThisMonth); }
    public static function lastMonth() { return static::fromPreset(DateRangePreset::LastMonth); }
    public static function thisQuarter() { return static::fromPreset(DateRangePreset::ThisQuarter); }
    public static function lastQuarter() { return static::fromPreset(DateRangePreset::LastQuarter); }
    public static function thisYear() { return static::fromPreset(DateRangePreset::ThisYear); }
    public static function lastYear() { return static::fromPreset(DateRangePreset::LastYear); }
    public static function last14Days() { return static::fromPreset(DateRangePreset::Last14Days); }
    public static function last30Days() { return static::fromPreset(DateRangePreset::Last30Days); }
    public static function last3Months() { return static::fromPreset(DateRangePreset::Last3Months); }
    public static function last6Months() { return static::fromPreset(DateRangePreset::Last6Months); }
    public static function yearToDate() { return static::fromPreset(DateRangePreset::YearToDate); }
    public static function allTime($start) {
        $instance = new static(Carbon::parse($start), Carbon::now());

        $instance->preset = DateRangePreset::AllTime;

        return $instance;
    }
}
