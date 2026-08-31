<?php

namespace Flux\Code;

class CodeHighlights
{
    public function __construct(
        protected array $lines = [],
        protected array $characters = [],
    ) {}

    public static function parse(?string $value): self
    {
        $highlights = new self;

        foreach (array_filter(array_map('trim', explode(',', $value ?? ''))) as $range) {
            if (preg_match('/^(\d+):(\d+)-(\d+)$/', $range, $matches)) {
                [$line, $start, $end] = array_map('intval', array_slice($matches, 1));

                if ($line > 0 && $start > 0 && $end > $start) {
                    $highlights->characters[$line][] = [$start - 1, $end - 1];
                }

                continue;
            }

            if (ctype_digit($range) && (int) $range > 0) {
                $highlights->lines[] = [(int) $range, (int) $range];

                continue;
            }

            if (preg_match('/^(\d+)-(\d+)$/', $range, $matches)) {
                [$start, $end] = array_map('intval', array_slice($matches, 1));

                if ($start > 0 && $end >= $start) {
                    $highlights->lines[] = [$start, $end];
                }
            }
        }

        foreach ($highlights->characters as &$ranges) {
            usort($ranges, fn ($a, $b) => $a[0] <=> $b[0]);
        }
        unset($ranges);

        return $highlights;
    }

    public function includesLine(int $line): bool
    {
        foreach ($this->lines as [$start, $end]) {
            if ($line >= $start && $line <= $end) {
                return true;
            }
        }

        return false;
    }

    public function segments(string $text, int $line, int $offset = 0): array
    {
        $ranges = $this->characters[$line] ?? [];

        if ($ranges === []) {
            return [[$text, false]];
        }

        $segments = [];
        $cursor = 0;
        $length = mb_strlen($text);

        foreach ($ranges as [$start, $end]) {
            $start = max($start - $offset, $cursor);
            $end = min($end - $offset, $length);

            if ($start >= $end || $end <= 0 || $start >= $length) {
                continue;
            }

            if ($start > $cursor) {
                $segments[] = [mb_substr($text, $cursor, $start - $cursor), false];
            }

            $segments[] = [mb_substr($text, $start, $end - $start), true];
            $cursor = $end;
        }

        if ($cursor < $length) {
            $segments[] = [mb_substr($text, $cursor), false];
        }

        return $segments ?: [[$text, false]];
    }
}
