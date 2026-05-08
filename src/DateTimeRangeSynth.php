<?php

namespace Flux;

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
        return [
            'start' => $target->start()?->toDateTimeLocalString('minute'),
            'end' => $target->end()?->toDateTimeLocalString('minute'),
        ];
    }

    static function hydrateFromType($type, $value) {
        if ($value === '' || $value === null) return null;

        return new DateTimeRange($value['start'] ?? null, $value['end'] ?? null);
    }

    function dehydrate($target, $dehydrateChild)
    {
        return [[
            'start' => $target->start()?->toDateTimeLocalString('minute'),
            'end' => $target->end()?->toDateTimeLocalString('minute'),
        ], []];
    }

    function hydrate($value, $meta) {
        if ($value === '' || $value === null) return null;

        return new DateTimeRange($value['start'] ?? null, $value['end'] ?? null);
    }

    function set(&$target, $key, $value) {
        $target = match ($key) {
            'start' => new DateTimeRange($value, $target->end()),
            'end' => new DateTimeRange($target->start(), $value),
        };
    }

    function unset(&$target, $key) {
        $target = match ($key) {
            'start' => new DateTimeRange(null, $target->end()),
            'end' => new DateTimeRange($target->start(), null),
        };
    }
}
