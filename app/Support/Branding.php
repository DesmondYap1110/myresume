<?php

namespace App\Support;

use App\Models\ThemeSetting;
use Illuminate\Support\Str;

/**
 * Resolves config/branding.php plus the saved Theme Setting row into the
 * colour tokens and login background the admin layout needs.
 */
class Branding
{
    public static function get(string $key, mixed $default = null): mixed
    {
        return config("branding.{$key}", $default);
    }

    /**
     * Renders declarations for one CSS rule. Values are emitted unescaped
     * into a <style> block, so anything that could break out of it is stripped.
     *
     * @param  array<string, string>  $declarations
     */
    public static function cssDeclarations(array $declarations): string
    {
        return collect($declarations)
            ->map(fn ($value, $property) => static::cssSafe($property).': '.static::cssSafe($value).';')
            ->implode("\n        ");
    }

    private static function cssSafe(string $value): string
    {
        return trim(str_replace(['<', '>', '{', '}', ';', '@'], '', $value));
    }

    /**
     * Absolute URLs and data URIs pass through; anything else is a public/ path.
     */
    public static function url(?string $path): string
    {
        if (blank($path)) {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    /**
     * default preset < chosen preset < colours changed in Theme Setting.
     *
     * @return array<string, string>
     */
    public static function colors(): array
    {
        $saved = ThemeSetting::cached();

        return static::resolveColors(
            (array) static::get('presets', []),
            $saved['preset'] ?: (string) static::get('theme', 'default'),
            static::expandCustomColors($saved['colors']),
        );
    }

    /**
     * @param  array<string, array<string, string>>  $presets
     * @param  array<string, string>  $custom
     * @return array<string, string>
     */
    public static function resolveColors(array $presets, string $theme, array $custom): array
    {
        $resolved = array_merge((array) ($presets['default'] ?? []), (array) ($presets[$theme] ?? []));

        foreach ($custom as $token => $value) {
            if (filled($value)) {
                $resolved[$token] = $value;
            }
        }

        return array_filter($resolved, fn ($value) => filled($value));
    }

    /**
     * A custom primary also moves its darker hover shade.
     *
     * @param  array<string, mixed>  $custom
     * @return array<string, string>
     */
    public static function expandCustomColors(array $custom): array
    {
        $custom = array_filter($custom, fn ($value) => is_string($value) && static::isHex($value));
        $out = $custom;

        if (isset($custom['primary'])) {
            $out += ['primary-hover' => static::darken($custom['primary'], 15)];
        }

        return $out;
    }

    public static function isHex(string $value): bool
    {
        return (bool) preg_match('/^#[0-9A-Fa-f]{6}$/', $value);
    }

    /**
     * #RRGGBB moved $percent of the way towards black.
     */
    public static function darken(string $hex, int $percent): string
    {
        $factor = 1 - max(0, min(100, $percent)) / 100;

        return '#'.collect(str_split(ltrim($hex, '#'), 2))
            ->map(fn ($pair) => str_pad(dechex((int) round(hexdec($pair) * $factor)), 2, '0', STR_PAD_LEFT))
            ->implode('');
    }

    /**
     * Colours for one user's public website on a given template.
     *
     * Each template keeps its own scheme; with nothing saved for it, the
     * website follows the back-office theme.
     *
     * @return array<string, string>
     */
    public static function websiteColors($user, ?string $template = null): array
    {
        $template = $template ?: (string) config('website_templates.default', 'template1');
        $saved = \App\Models\WebsiteTheme::settingsFor($user->id ?? 0, $template);

        if (blank($saved['preset']) && empty($saved['colors'])) {
            return static::colors();
        }

        return static::resolveColors(
            (array) static::get('presets', []),
            $saved['preset'] ?: (string) static::get('theme', 'default'),
            static::expandCustomColors($saved['colors']),
        );
    }

    /**
     * @return array<string, string>
     */
    public static function websiteCssVariables($user, ?string $template = null): array
    {
        $vars = [];

        foreach (static::websiteColors($user, $template) as $token => $value) {
            $vars["--brand-{$token}"] = $value;
        }

        return $vars;
    }

    /**
     * @return array<string, string>
     */
    public static function cssVariables(): array
    {
        $vars = [];

        foreach (static::colors() as $token => $value) {
            $vars["--brand-{$token}"] = $value;
        }

        return $vars;
    }

    /**
     * Config background with anything saved under Theme Setting on top.
     * Overlay comes back as a CSS colour.
     *
     * @return array<string, mixed>
     */
    public static function loginBackground(): array
    {
        $background = (array) static::get('background', []);
        $saved = ThemeSetting::cached();

        if (filled($saved['login_image'])) {
            $background['image'] = $saved['login_image'] === 'none' ? '' : $saved['login_image'];
        }

        if (filled($saved['login_color']) && static::isHex($saved['login_color'])) {
            $background['colour'] = $saved['login_color'];
        }

        if ($saved['login_overlay'] !== null) {
            $background['overlay'] = 'rgba(0, 0, 0, '.round(max(0, min(80, (int) $saved['login_overlay'])) / 100, 2).')';
        }

        return $background;
    }

    /**
     * CSS declarations for the login background: a flat colour when there is
     * no image, otherwise the overlay layered over the image.
     *
     * @return array<string, string>
     */
    public static function backgroundStyles(): array
    {
        $background = static::loginBackground();
        $image = trim((string) ($background['image'] ?? ''));
        $overlay = trim((string) ($background['overlay'] ?? ''));
        $colour = (string) ($background['colour'] ?? '');

        if ($image === '') {
            return array_filter(['background' => $colour]);
        }

        $layers = [];

        if ($overlay !== '' && $overlay !== 'rgba(0, 0, 0, 0)') {
            $layers[] = "linear-gradient({$overlay}, {$overlay})";
        }

        $layers[] = 'url("'.static::url($image).'")';

        return array_filter([
            'background-color' => $colour,
            'background-image' => implode(', ', $layers),
            'background-size' => $background['size'] ?? null,
            'background-position' => $background['position'] ?? null,
            'background-repeat' => $background['repeat'] ?? null,
            'background-attachment' => $background['attachment'] ?? null,
        ]);
    }
}
