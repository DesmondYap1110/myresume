<?php

namespace App\Support;

/**
 * A member's links to other places on the web.
 *
 * Two kinds: the networks listed in config/social.php, and any number of
 * links added by hand. Both carry a switch, so a link can be kept without
 * being shown - turning a network off does not lose the address.
 *
 * Nothing a member types is shown as a link until it has been checked here:
 * it must be http(s), and a known network's link must actually be on that
 * network's own domain. That stops a lookalike address being passed off as,
 * say, a LinkedIn profile.
 */
class SocialLinks
{
    /** How many links a member may add by hand. */
    public const maxCustom = 10;

    public static function networks(): array
    {
        return (array) config('social.networks', []);
    }

    /** The stored value, always in the shape the rest of this class expects. */
    public static function normalise($stored): array
    {
        if (is_string($stored)) {
            $stored = json_decode($stored, true);
        }

        $stored = is_array($stored) ? $stored : [];

        return [
            'networks' => (array) ($stored['networks'] ?? []),
            'custom' => array_values(array_filter((array) ($stored['custom'] ?? []), 'is_array')),
        ];
    }

    /**
     * What the form shows: every known network in order, with whatever the
     * member has saved, then their own links.
     */
    public static function forForm($user): array
    {
        $saved = self::normalise($user->social_links);
        $rows = [];

        foreach (self::networks() as $key => $network) {
            $url = (string) ($saved['networks'][$key]['url'] ?? '');

            // Anything filled in before this existed carries over.
            if ($key === 'linkedin' && $url === '' && filled($user->linkedIn_url)) {
                $url = (string) $user->linkedIn_url;
            }

            if ($key === 'whatsapp' && $url === '' && filled($user->phone)) {
                $url = 'https://wa.me/'.preg_replace('/\D+/', '', (string) $user->phone);
            }

            $rows[$key] = [
                'key' => $key,
                'label' => $network['label'] ?? $key,
                'icon' => $network['icon'] ?? 'fas fa-link',
                'brand' => $network['brand'] ?? '#6c757d',
                'svg' => $network['svg'] ?? null,
                'placeholder' => $network['placeholder'] ?? 'https://',
                'url' => $url,
                'show' => (bool) ($saved['networks'][$key]['show'] ?? ($url !== '')),
            ];
        }

        return ['networks' => $rows, 'custom' => $saved['custom']];
    }

    /**
     * What the public website shows: the links that are filled in, switched
     * on and valid, in config order with the member's own links last.
     */
    public static function forWebsite($user): array
    {
        $saved = self::normalise($user->social_links);
        $out = [];

        foreach (self::networks() as $key => $network) {
            $row = $saved['networks'][$key] ?? null;
            $url = (string) ($row['url'] ?? '');

            if ($key === 'linkedin' && $url === '' && filled($user->linkedIn_url) && $row === null) {
                $url = (string) $user->linkedIn_url;
            }

            if ($url === '' || !($row['show'] ?? ($url !== ''))) {
                continue;
            }

            if (!self::valid($url, $network['host'] ?? [])) {
                continue;
            }

            $out[] = [
                'key' => $key,
                'label' => $network['label'] ?? $key,
                'icon' => $network['icon'] ?? 'fas fa-link',
                'svg' => $network['svg'] ?? null,
                'brand' => $network['brand'] ?? '#6c757d',
                'url' => $url,
            ];
        }

        foreach ($saved['custom'] as $link) {
            $url = (string) ($link['url'] ?? '');

            if ($url === '' || !($link['show'] ?? true) || !self::valid($url)) {
                continue;
            }

            $out[] = [
                'key' => 'custom',
                'label' => (string) ($link['label'] ?? '') ?: parse_url($url, PHP_URL_HOST),
                'icon' => 'fas fa-link',
                'svg' => null,
                'brand' => '#6c757d',
                'url' => $url,
            ];
        }

        return $out;
    }

    /**
     * Turn what the form posted into what is stored.
     *
     * A blank address clears that network. A switch on its own is kept, so a
     * hidden link is not thrown away.
     */
    public static function fromRequest(array $networks, array $custom): array
    {
        $known = self::networks();
        $out = ['networks' => [], 'custom' => []];

        foreach ($known as $key => $network) {
            $url = trim((string) ($networks[$key]['url'] ?? ''));

            if ($url === '') {
                continue;
            }

            $out['networks'][$key] = [
                'url' => $url,
                'show' => (bool) ($networks[$key]['show'] ?? false),
            ];
        }

        foreach (array_slice($custom, 0, self::maxCustom) as $link) {
            $url = trim((string) ($link['url'] ?? ''));
            $label = trim((string) ($link['label'] ?? ''));

            if ($url === '') {
                continue;
            }

            $out['custom'][] = [
                'label' => mb_substr($label, 0, 40),
                'url' => $url,
                'show' => (bool) ($link['show'] ?? false),
            ];
        }

        return ($out['networks'] || $out['custom']) ? $out : [];
    }

    /**
     * http(s) only, and on the network's own domain when one is named.
     *
     * The host must equal the domain or be a subdomain of it - a plain
     * "contains" would let linkedin.com.evil.test through.
     */
    public static function valid(string $url, array $hosts = []): bool
    {
        if (!preg_match('~^https?://~i', $url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        if (!$hosts) {
            return true;
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        foreach ($hosts as $allowed) {
            $allowed = strtolower($allowed);

            if ($host === $allowed || str_ends_with($host, '.'.$allowed)) {
                return true;
            }
        }

        return false;
    }

    /** The message shown when a network's link is on the wrong domain. */
    public static function hostMessage(string $key): string
    {
        $network = self::networks()[$key] ?? [];
        $hosts = (array) ($network['host'] ?? []);

        return trans('admin.ui.social_wrong_host', [
            'network' => $network['label'] ?? $key,
            'host' => implode(' or ', $hosts),
        ]);
    }
}
