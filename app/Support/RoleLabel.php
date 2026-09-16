<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Short job titles for the animated headlines.
 *
 * A CV title like "Senior Associate - Financial Services Assurance" is too
 * long for a one-line headline, so only the part before the dash, slash or
 * comma is kept. The full title is still shown in the Experience section.
 */
class RoleLabel
{
    /** "Senior Manager, Forecast and Budgeting" -> "Senior Manager" */
    public static function short(?string $role, int $limit = 28): string
    {
        $role = trim(preg_replace('/\s+/', ' ', strip_tags((string) $role)));

        if ($role === '') {
            return '';
        }

        // Cut at the first separator that introduces the specialism.
        $role = preg_split('/\s+[-–—\/|]\s+|,/u', $role)[0] ?? $role;
        $role = trim($role);

        return Str::limit($role, $limit, '');
    }

    /**
     * A short, de-duplicated list for a rotating headline.
     *
     * @param  iterable<object>  $experience
     * @return array<int, string>
     */
    public static function headlineWords($experience, ?string $currentRole = null, int $max = 4): array
    {
        $words = collect($experience)->pluck('role')
            ->prepend($currentRole)
            ->map(fn ($role) => static::short($role))
            ->filter()
            ->unique(fn ($role) => Str::lower($role))
            ->take($max)
            ->values()
            ->all();

        return $words;
    }
}
