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
        $data = [
            'start' => $target->start()?->toDateTimeLocalString('minute'),
            'end' => $target->end()?->toDateTimeLocalString('minute'),
        ];

        $preset = $target->preset();

        $preset && $data['preset'] = $preset->value;

        return $data;
    }

    static function hydrateFromType($type, $value) {
        if ($value === '' || $value === null) return null;

        $preset = $value['preset'] ?? null;

        if ($preset) {
            if ($preset === DateTimeRangePreset::AllTime->value) {
                return DateTimeRange::allTime($value['start']);
            }

            return DateTimeRange::fromPreset(DateTimeRangePreset::from($preset));
        }

        return new DateTimeRange($value['start'] ?? null, $value['end'] ?? null);
    }

    function dehydrate($target, $dehydrateChild)
    {
        $data = [
            'start' => $target->start()?->toDateTimeLocalString('minute'),
            'end' => $target->end()?->toDateTimeLocalString('minute'),
        ];

        $preset = $target->preset();

        $preset && $data['preset'] = $preset->value;

        return [$data, []];
    }

    function hydrate($value, $meta) {
        if ($value === '' || $value === null) return null;

        $preset = $value['preset'] ?? null;

        if ($preset) {
            if ($preset === DateTimeRangePreset::AllTime->value) {
                return DateTimeRange::allTime($value['start']);
            }

            return DateTimeRange::fromPreset(DateTimeRangePreset::from($preset));
        }

        return new DateTimeRange($value['start'] ?? null, $value['end'] ?? null);
    }

    function set(&$target, $key, $value) {
        $target = match ($key) {
            'start' => new DateTimeRange($value, $target->end()),
            'end' => new DateTimeRange($target->start(), $value),
            'preset' => $value === DateTimeRangePreset::AllTime->value
                ? DateTimeRange::allTime($target->start())
                : DateTimeRange::fromPreset(DateTimeRangePreset::from($value)),
        };
    }

    function unset(&$target, $key) {
        $target = match ($key) {
            'start' => new DateTimeRange(null, $target->end()),
            'end' => new DateTimeRange($target->start(), null),
            'preset' => new DateTimeRange($target->start(), $target->end()),
        };
    }
}
