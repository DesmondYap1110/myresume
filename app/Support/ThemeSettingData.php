<?php

namespace App\Support;

use App\Models\ThemeSetting;
use Illuminate\Support\Str;

/**
 * Everything the Theme Setting form needs, shared by the controllers that
 * render it (Account Setting) and the one that saves it.
 */
class ThemeSettingData
{
    public static function forView(): array
    {
        $setting = ThemeSetting::current();
        $presets = (array) Branding::get('presets', []);

        return [
            'presets' => collect($presets)->map(fn ($colors, $key) => [
                'key' => $key,
                'label' => $key === 'default' ? 'Black Gold' : Str::headline($key),
                'colors' => Branding::resolveColors($presets, $key, []),
            ])->values(),
            'activePreset' => $setting->preset ?: (string) Branding::get('theme', 'default'),
            'current' => Branding::colors(),
            'editable' => ThemeSetting::EDITABLE,
            'login' => Branding::loginBackground(),
            'loginImages' => ThemeSetting::LOGIN_IMAGES,
            'loginUploaded' => ThemeSetting::isUploadedLoginImage($setting->login_background_image) ? $setting->login_background_image : null,
            'loginOverlay' => $setting->login_overlay ?? static::overlayPercent((string) Branding::get('background.overlay', '')),
        ];
    }

    /** "rgba(0, 0, 0, 0.35)" -> 35; anything else -> 0. */
    public static function overlayPercent(string $css): int
    {
        return preg_match('/rgba\([^,]+,[^,]+,[^,]+,\s*([\d.]+)\)/', $css, $m) ? (int) round((float) $m[1] * 100) : 0;
    }
}
