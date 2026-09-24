<?php

namespace App\Support;

use App\Models\Visit_Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Turns visitor IP addresses into a country and city.
 *
 * Addresses are resolved in batches when the Visitor page is opened, never
 * while somebody is browsing the public site, and the answer is written back
 * to every row with that address - so each address costs one lookup ever.
 *
 * A failed lookup is not an error worth showing anyone: the page simply says
 * "Unknown" and tries again the next time it is opened.
 */
class IpLocation
{
    /** ip-api.com takes up to 100 addresses in one request, free, no key. */
    private const endpoint = 'http://ip-api.com/batch';
    private const batch = 100;
    private const timeout = 4;

    /**
     * Fill in country and city for any of these visits that lack them.
     *
     * @param  \Illuminate\Support\Collection<int, Visit_Log>  $visits
     */
    public static function fill($visits): void
    {
        $unknown = $visits
            ->filter(fn ($v) => blank($v->located_at) && filled($v->ip_address))
            ->pluck('ip_address')
            ->unique()
            ->reject(fn ($ip) => static::isPrivate($ip))
            ->take(self::batch)
            ->values();

        // Private addresses never need asking about; mark them once so they
        // are not reconsidered on every page load.
        $private = $visits
            ->filter(fn ($v) => blank($v->located_at) && static::isPrivate($v->ip_address))
            ->pluck('ip_address')
            ->unique();

        foreach ($private as $ip) {
            static::store($ip, 'Local network', null);
        }

        if ($unknown->isEmpty()) {
            static::refresh($visits);

            return;
        }

        try {
            $response = Http::timeout(self::timeout)
                ->acceptJson()
                ->post(self::endpoint, $unknown->map(fn ($ip) => [
                    'query' => $ip,
                    'fields' => 'status,country,city,query',
                ])->all());

            if (!$response->successful()) {
                return;
            }

            foreach ((array) $response->json() as $row) {
                $ip = (string) ($row['query'] ?? '');

                if ($ip === '') {
                    continue;
                }

                $ok = ($row['status'] ?? '') === 'success';

                static::store(
                    $ip,
                    $ok ? ($row['country'] ?: null) : null,
                    $ok ? ($row['city'] ?: null) : null,
                );
            }
        } catch (\Throwable $e) {
            // The page is still useful without locations, so a provider that
            // is down or unreachable must not break it.
            Log::warning('IP location lookup failed: '.$e->getMessage());

            return;
        }

        static::refresh($visits);
    }

    /** Write the answer to every row with that address, past and future. */
    private static function store(string $ip, ?string $country, ?string $city): void
    {
        Visit_Log::where('ip_address', $ip)->update([
            'country' => $country,
            'city' => $city,
            'located_at' => now(),
        ]);
    }

    /** Put what was just stored onto the models already in hand. */
    private static function refresh($visits): void
    {
        $found = Visit_Log::whereIn('ip_address', $visits->pluck('ip_address')->unique()->all())
            ->whereNotNull('located_at')
            ->get(['ip_address', 'country', 'city', 'located_at'])
            ->keyBy('ip_address');

        foreach ($visits as $visit) {
            $row = $found[$visit->ip_address] ?? null;

            if ($row) {
                $visit->country = $row->country;
                $visit->city = $row->city;
                $visit->located_at = $row->located_at;
            }
        }
    }

    /** Loopback, LAN and link-local addresses have no country to report. */
    public static function isPrivate(?string $ip): bool
    {
        if (blank($ip)) {
            return true;
        }

        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) === false;
    }

    /** "Kuala Lumpur, Malaysia", "Malaysia", or "Unknown". */
    public static function label(?string $country, ?string $city): string
    {
        return collect([$city, $country])->filter()->implode(', ') ?: 'Unknown';
    }
}
