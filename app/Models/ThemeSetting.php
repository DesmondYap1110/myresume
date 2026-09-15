<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Throwable;

/**
 * The theme chosen under Theme Setting. One row, id 1. Read on every admin
 * page, so it is cached and the cache is dropped whenever the row changes.
 */
class ThemeSetting extends Model
{
    public const CACHE_KEY = 'theme_setting';

    /** The colours an admin may change. */
    public const EDITABLE = [
        'primary' => 'Primary - buttons',
        'button-text' => 'Button text',
        'accent' => 'Accent - sidebar menu, website highlights',
        'sidebar' => 'Sidebar - also website cards',
        'logo-header' => 'Logo header - also website background',
        'background' => 'Page background',
        'link' => 'Links',
    ];

    /** Built-in login backgrounds, under public/. */
    public const LOGIN_IMAGES = [
        // Black & gold vector backgrounds made for the Black Gold theme.
        'assets/admin/img/bg/black-gold-waves.svg',
        'assets/admin/img/bg/black-hex.svg',
        'assets/admin/img/bg/black-marble.svg',
        'assets/admin/img/bg/bg-3.jpg',
        'assets/admin/img/bg/bg.jpg',
        'assets/admin/img/bg/bg-1.jpg',
        'assets/admin/img/bg/bg-2.jpg',
        'assets/admin/img/bg/green-waves.svg',
        'assets/admin/img/bg/green-mesh.svg',
        'assets/admin/img/bg/green-leaves.svg',
    ];

    /** Where uploaded login backgrounds go, under public/. */
    public const LOGIN_UPLOAD_DIR = 'uploads/login-backgrounds';

    protected $table = 'theme_setting';

    protected $fillable = ['preset', 'colors', 'login_background_image', 'login_background_color', 'login_overlay'];

    protected $casts = ['colors' => 'array', 'login_overlay' => 'integer'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }

    /**
     * The saved choice as plain values, or nulls when there is none - including
     * before the table exists, so the layout never fails on its colours.
     *
     * @return array{preset: string|null, colors: array<string, string>, login_image: string|null, login_color: string|null, login_overlay: int|null}
     */
    public static function cached(): array
    {
        $empty = ['preset' => null, 'colors' => [], 'login_image' => null, 'login_color' => null, 'login_overlay' => null];

        try {
            return Cache::rememberForever(self::CACHE_KEY, function () use ($empty) {
                $row = static::find(1);

                return $row ? [
                    'preset' => $row->preset,
                    'colors' => (array) ($row->colors ?? []),
                    'login_image' => $row->login_background_image,
                    'login_color' => $row->login_background_color,
                    'login_overlay' => $row->login_overlay,
                ] : $empty;
            }) + $empty;
        } catch (Throwable) {
            return $empty;
        }
    }

    public static function isUploadedLoginImage(?string $path): bool
    {
        return is_string($path) && str_starts_with($path, self::LOGIN_UPLOAD_DIR.'/') && ! str_contains($path, '..');
    }
}
