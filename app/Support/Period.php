<?php

namespace App\Support;

/**
 * Formats the start/end dates shown on the public site.
 *
 * Dates are stored as "YYYY-MM" when the month is known and "YYYY" when only
 * the year is (LinkedIn often gives just a year), so a year-only record is
 * never shown as a made-up month.
 */
class Period
{
    /** "August 2022", "2015", or null. */
    public static function point(?string $value, bool $short = false): ?string
    {
        $value = trim((string) $value);

        if ($value === '' || $value === '1970-01-01') {
            return null;
        }

        if (preg_match('/^\d{4}$/', $value)) {
            return $value;
        }

        if (preg_match('/^(\d{4})-(\d{2})/', $value, $m)) {
            $time = mktime(0, 0, 0, (int) $m[2], 1, (int) $m[1]);
            return date($short ? 'M Y' : 'F Y', $time);
        }

        $time = strtotime($value);

        return $time ? date($short ? 'M Y' : 'F Y', $time) : null;
    }

    /** "August 2022 - Present", "2012 - 2015", or "2021". */
    public static function label(?string $start, ?string $end, bool $short = false, string $present = 'Present'): string
    {
        $from = static::point($start, $short);
        $to = static::point($end, $short);

        if ($from && $to) {
            return $from === $to ? $from : $from.' - '.$to;
        }

        if ($from) {
            return $from.' - '.$present;
        }

        return $to ?: '';
    }
}
