<?php

namespace Flux;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DateTimeRange extends CarbonPeriod
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

    public function preset(): ?DateTimeRangePreset
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
        return $this->preset !== DateTimeRangePreset::AllTime;
    }

    public static function fromPreset(DateTimeRangePreset $preset)
    {
        if ($preset === DateTimeRangePreset::AllTime) {
            throw new \Exception('All time datetime range is not supported via this constructor because it requires a start datetime. Please use the ::allTime($start) constructor instead.');
        }

        $instance = new static(...$preset->dates());

        $instance->preset = $preset;

        return $instance;
    }

    public static function today() { return static::fromPreset(DateTimeRangePreset::Today); }
    public static function yesterday() { return static::fromPreset(DateTimeRangePreset::Yesterday); }
    public static function thisWeek() { return static::fromPreset(DateTimeRangePreset::ThisWeek); }
    public static function lastWeek() { return static::fromPreset(DateTimeRangePreset::LastWeek); }
    public static function last7Days() { return static::fromPreset(DateTimeRangePreset::Last7Days); }
    public static function thisMonth() { return static::fromPreset(DateTimeRangePreset::ThisMonth); }
    public static function lastMonth() { return static::fromPreset(DateTimeRangePreset::LastMonth); }
    public static function thisQuarter() { return static::fromPreset(DateTimeRangePreset::ThisQuarter); }
    public static function lastQuarter() { return static::fromPreset(DateTimeRangePreset::LastQuarter); }
    public static function thisYear() { return static::fromPreset(DateTimeRangePreset::ThisYear); }
    public static function lastYear() { return static::fromPreset(DateTimeRangePreset::LastYear); }
    public static function last14Days() { return static::fromPreset(DateTimeRangePreset::Last14Days); }
    public static function last30Days() { return static::fromPreset(DateTimeRangePreset::Last30Days); }
    public static function last3Months() { return static::fromPreset(DateTimeRangePreset::Last3Months); }
    public static function last6Months() { return static::fromPreset(DateTimeRangePreset::Last6Months); }
    public static function yearToDate() { return static::fromPreset(DateTimeRangePreset::YearToDate); }
    public static function tomorrow() { return static::fromPreset(DateTimeRangePreset::Tomorrow); }
    public static function nextWeek() { return static::fromPreset(DateTimeRangePreset::NextWeek); }
    public static function next7Days() { return static::fromPreset(DateTimeRangePreset::Next7Days); }
    public static function nextMonth() { return static::fromPreset(DateTimeRangePreset::NextMonth); }
    public static function nextQuarter() { return static::fromPreset(DateTimeRangePreset::NextQuarter); }
    public static function nextYear() { return static::fromPreset(DateTimeRangePreset::NextYear); }
    public static function next14Days() { return static::fromPreset(DateTimeRangePreset::Next14Days); }
    public static function next30Days() { return static::fromPreset(DateTimeRangePreset::Next30Days); }
    public static function next3Months() { return static::fromPreset(DateTimeRangePreset::Next3Months); }
    public static function next6Months() { return static::fromPreset(DateTimeRangePreset::Next6Months); }
    public static function lastHour() { return static::fromPreset(DateTimeRangePreset::LastHour); }
    public static function nextHour() { return static::fromPreset(DateTimeRangePreset::NextHour); }
    public static function last24Hours() { return static::fromPreset(DateTimeRangePreset::Last24Hours); }
    public static function next24Hours() { return static::fromPreset(DateTimeRangePreset::Next24Hours); }

    public static function allTime($start)
    {
        $instance = new static(Carbon::parse($start), Carbon::now());

        $instance->preset = DateTimeRangePreset::AllTime;

        return $instance;
    }
}
