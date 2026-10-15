<?php

namespace Flux;

use Carbon\Carbon;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class DateTimeRangeSynth extends Synth
{
    public static $key = 'fxdtr';

    static function match($target)
    {
        return is_object($target) && $target instanceof DateTimeRange;
    }

    static function matchByType($type) {
        return $type === DateTimeRange::class;
    }

    static function unwrapForValidation($target) {
        return static::toArray($target);
    }

    static function hydrateFromType($type, $value) {
        return static::fromArray($value);
    }

    // The browser only deals in wall-clock times, so the timezone travels in the metadata
    // to keep a range in the same timezone it was created in across requests...
    function dehydrate($target, $dehydrateChild)
    {
        return [static::toArray($target), ['tz' => $target->start()?->getTimezone()->getName()]];
    }

    function hydrate($value, $meta) {
        return static::fromArray($value, $meta['tz'] ?? null);
    }

    function set(&$target, $key, $value) {
        $timezone = $target->start()?->getTimezone()->getName();

        $start = $key === 'start' ? $value : $target->start();
        $end = $key === 'end' ? $value : $target->end();

        $target = static::fromArray(['start' => $start, 'end' => $end], $timezone);
    }

    // A range needs both ends, so removing either one clears it...
    function unset(&$target, $key) {
        $target = null;
    }

    // Datetimes are sent to the browser in the same `Y-m-d\TH:i` format as a `datetime-local` input...
    protected static function toArray(DateTimeRange $target): array
    {
        return [
            'start' => $target->start()?->format('Y-m-d\TH:i'),
            'end' => $target->end()?->format('Y-m-d\TH:i'),
        ];
    }

    protected static function fromArray($value, $timezone = null): ?DateTimeRange
    {
        if (blank($value['start'] ?? null) || blank($value['end'] ?? null)) return null;

        $parse = fn ($datetime) => $datetime instanceof \DateTimeInterface
            ? Carbon::instance($datetime)
            : Carbon::parse($datetime, $timezone);

        return new DateTimeRange($parse($value['start']), $parse($value['end']));
    }
}
