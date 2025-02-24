<?php

namespace Flux;

use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class DateRangeSynth extends Synth
{
    public static $key = 'fxdr';

    static function match($target)
    {
        return is_object($target) && $target instanceof DateRange;
    }

    static function matchByType($type) {
        return $type === DateRange::class;
    }

    static function hydrateFromType($type, $value) {
        if ($value === '' || $value === null) return null;

        $preset = $value['preset'] ?? null;

        if ($preset) {
            if ($preset === DateRangePreset::AllTime->value) {
                return DateRange::allTime($value['start']);
            }

            return DateRange::fromPreset(DateRangePreset::from($preset));
        }

        return new DateRange($value['start'] ?? null, $value['end'] ?? null);
    }

    function dehydrate($target, $dehydrateChild)
    {
        $data = [
            'start' => $target->start()?->format('Y-m-d'),
            'end' => $target->end()?->format('Y-m-d'),
        ];

        $preset = $target->preset();

        $preset && $data['preset'] = $preset->value;

        return [$data, []];
    }

    function hydrate($value, $meta) {
        if ($value === '' || $value === null) return null;

        $preset = $value['preset'] ?? null;

        if ($preset) {
            if ($preset === DateRangePreset::AllTime->value) {
                return DateRange::allTime($value['start']);
            }

            return DateRange::fromPreset(DateRangePreset::from($preset));
        }

        return new DateRange($value['start'] ?? null, $value['end'] ?? null);
    }

    function set(&$target, $key, $value) {
        $target = match ($key) {
            'start' => new DateRange($value, $target->end()),
            'end' => new DateRange($target->start(), $value),
            'preset' => $value === DateRangePreset::AllTime->value
                ? DateRange::allTime($target->start())
                : DateRange::fromPreset(DateRangePreset::from($value)),
        };
    }

    function unset(&$target, $key) {
        $target = match ($key) {
            'start' => new DateRange(null, $target->end()),
            'end' => new DateRange($target->start(), null),
            'preset' => new DateRange($target->start(), $target->end()),
        };
    }
}
