<?php

namespace App\Support;

/**
 * Turns a pasted YouTube, Instagram or X link into something playable.
 *
 * Nothing a member types ever reaches an iframe src. Each provider is matched
 * against a strict pattern, the video or post id is pulled out, and the embed
 * address is rebuilt from that id - so a link cannot smuggle in a different
 * host, a javascript: URL, or extra query parameters.
 *
 * A link that matches nothing is not an error: it is kept and shown as an
 * ordinary link, so members are never told their URL is "wrong".
 */
class MediaEmbed
{
    public const providers = ['youtube', 'instagram', 'twitter', 'vimeo', 'link'];

    /** How many a single post may carry. */
    public const max = 8;

    /**
     * @return array{provider: string, id: ?string, url: string, embed: ?string, label: string}
     */
    public static function parse(string $url): array
    {
        $url = trim($url);

        // Only ever http(s). Anything else is not linked at all.
        if (!preg_match('~^https?://~i', $url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            return self::plain($url, false);
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $host = preg_replace('/^www\./', '', $host);

        // youtu.be/ID  |  youtube.com/watch?v=ID  |  /embed/ID  |  /shorts/ID  |  /live/ID
        if (in_array($host, ['youtube.com', 'm.youtube.com', 'youtu.be', 'youtube-nocookie.com'], true)) {
            if (preg_match('~(?:youtu\.be/|/embed/|/shorts/|/live/|[?&]v=)([A-Za-z0-9_-]{11})~', $url, $m)) {
                return [
                    'provider' => 'youtube',
                    'id' => $m[1],
                    'url' => 'https://www.youtube.com/watch?v='.$m[1],
                    'embed' => 'https://www.youtube-nocookie.com/embed/'.$m[1],
                    'label' => 'YouTube',
                ];
            }
        }

        // instagram.com/p/CODE  |  /reel/CODE  |  /tv/CODE
        if (in_array($host, ['instagram.com', 'instagr.am'], true)) {
            if (preg_match('~/(p|reel|reels|tv)/([A-Za-z0-9_-]{5,20})~', $url, $m)) {
                $type = $m[1] === 'reels' ? 'reel' : $m[1];

                return [
                    'provider' => 'instagram',
                    'id' => $m[2],
                    'url' => 'https://www.instagram.com/'.$type.'/'.$m[2].'/',
                    'embed' => 'https://www.instagram.com/'.$type.'/'.$m[2].'/embed/',
                    'label' => 'Instagram',
                ];
            }
        }

        // twitter.com/user/status/ID  |  x.com/user/status/ID
        if (in_array($host, ['twitter.com', 'x.com', 'mobile.twitter.com'], true)) {
            // Ids are 19 digits now but the earliest tweets are two, so any length.
            if (preg_match('~/([A-Za-z0-9_]{1,15})/status(?:es)?/(\d{1,25})~', $url, $m)) {
                return [
                    'provider' => 'twitter',
                    'id' => $m[2],
                    'url' => 'https://twitter.com/'.$m[1].'/status/'.$m[2],
                    // Rendered through the platform's own widget, not an iframe.
                    'embed' => null,
                    'label' => 'X (Twitter)',
                ];
            }
        }

        // vimeo.com/ID
        if (in_array($host, ['vimeo.com', 'player.vimeo.com'], true)) {
            if (preg_match('~/(?:video/)?(\d{6,12})~', $url, $m)) {
                return [
                    'provider' => 'vimeo',
                    'id' => $m[1],
                    'url' => 'https://vimeo.com/'.$m[1],
                    'embed' => 'https://player.vimeo.com/video/'.$m[1],
                    'label' => 'Vimeo',
                ];
            }
        }

        return self::plain($url, true);
    }

    /** Several at once, bad ones dropped, duplicates removed, capped. */
    public static function parseMany($urls): array
    {
        return collect((array) $urls)
            ->map(fn ($url) => is_string($url) ? trim($url) : '')
            ->filter()
            ->unique()
            ->take(self::max)
            ->map(fn ($url) => self::parse($url))
            ->filter(fn ($media) => $media['url'] !== '')
            ->values()
            ->all();
    }

    /** Whether a post carries anything needing the X widget script. */
    public static function needsTwitterScript(array $media): bool
    {
        foreach ($media as $item) {
            if (($item['provider'] ?? '') === 'twitter') {
                return true;
            }
        }

        return false;
    }

    private static function plain(string $url, bool $linkable): array
    {
        return [
            'provider' => 'link',
            'id' => null,
            'url' => $linkable ? $url : '',
            'embed' => null,
            'label' => $linkable ? (string) parse_url($url, PHP_URL_HOST) : '',
        ];
    }
}
