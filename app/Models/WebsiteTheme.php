<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * One colour scheme per user per website template.
 */
class WebsiteTheme extends Model
{
    protected $table = 'website_theme';

    protected $fillable = ['user_id', 'template', 'preset', 'colors'];

    protected $casts = ['colors' => 'array'];

    /** Cached per request: the same page asks for this several times. */
    protected static array $loaded = [];

    /**
     * @return array{preset: string|null, colors: array<string, string>}
     */
    public static function settingsFor($userId, string $template): array
    {
        $key = $userId.'|'.$template;

        if (array_key_exists($key, static::$loaded)) {
            return static::$loaded[$key];
        }

        $empty = ['preset' => null, 'colors' => []];

        try {
            $row = static::where('user_id', (string) $userId)->where('template', $template)->first();
            $found = $row ? ['preset' => $row->preset, 'colors' => (array) ($row->colors ?? [])] : $empty;
        } catch (Throwable) {
            // Table not migrated yet: fall back to the back-office theme.
            $found = $empty;
        }

        return static::$loaded[$key] = $found;
    }

    public static function forget(): void
    {
        static::$loaded = [];
    }
}
