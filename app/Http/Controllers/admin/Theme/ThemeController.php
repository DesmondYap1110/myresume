<?php

namespace App\Http\Controllers\admin\Theme;

use App\Helpers\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use App\Support\Branding;
use App\Support\SafeImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Theme Setting: pick a colour preset, tweak its colours, and choose the
 * login page background. Saved values layer over config/branding.php.
 */
class ThemeController extends Controller
{
    const page = "Theme";
    const viewPath = "admin.template1.theme.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $setting = ThemeSetting::current();
        $presets = (array) Branding::get('presets', []);

        return view(self::viewPath . 'index', [
            'breadcrumbs' => $breadcrumbs,
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
            'loginOverlay' => $setting->login_overlay ?? $this->overlayPercent((string) Branding::get('background.overlay', '')),
        ]);
    }

    public function update(Request $request)
    {
        $presets = array_keys((array) Branding::get('presets', []));
        $setting = ThemeSetting::current();

        $validated = $request->validate([
            'preset' => ['required', Rule::in($presets)],
            'colors' => ['array'],
            'colors.*' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'login_image' => ['required', Rule::in(array_merge(ThemeSetting::LOGIN_IMAGES, ['none', 'uploaded', 'upload']))],
            'login_upload' => ['nullable', 'required_if:login_image,upload', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'login_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'login_overlay' => ['required', 'integer', 'min:0', 'max:80'],
        ], [
            'colors.*.regex' => 'Each colour must be a hex value like #22A65E.',
            'login_color.regex' => 'The login colour must be a hex value like #000000.',
            'login_upload.required_if' => 'Choose an image file to upload.',
        ]);

        $loginImage = match ($validated['login_image']) {
            'uploaded' => ThemeSetting::isUploadedLoginImage($setting->login_background_image) ? $setting->login_background_image : null,
            'upload' => SafeImageUpload::store($request->file('login_upload'), ThemeSetting::LOGIN_UPLOAD_DIR, 'login_upload'),
            default => $validated['login_image'],
        };

        if (ThemeSetting::isUploadedLoginImage($setting->login_background_image) && $setting->login_background_image !== $loginImage) {
            $this->deleteUpload($setting->login_background_image);
        }

        // Only keep colours that differ from the preset, so they keep following it.
        $base = Branding::resolveColors((array) Branding::get('presets', []), $validated['preset'], []);
        $colors = collect($validated['colors'] ?? [])
            ->only(array_keys(ThemeSetting::EDITABLE))
            ->filter(fn ($value, $token) => filled($value) && strcasecmp($value, $base[$token] ?? '') !== 0)
            ->map(fn ($value) => strtoupper($value))
            ->all();

        $setting->update([
            'preset' => $validated['preset'],
            'colors' => $colors ?: null,
            'login_background_image' => $loginImage,
            'login_background_color' => strtoupper($validated['login_color']),
            'login_overlay' => (int) $validated['login_overlay'],
        ]);

        return back()->with('success', 'Theme saved successfully!');
    }

    public function reset()
    {
        $setting = ThemeSetting::current();

        if (ThemeSetting::isUploadedLoginImage($setting->login_background_image)) {
            $this->deleteUpload($setting->login_background_image);
        }

        $setting->update([
            'preset' => null, 'colors' => null,
            'login_background_image' => null, 'login_background_color' => null, 'login_overlay' => null,
        ]);

        return back()->with('success', 'Theme reset to default!');
    }

    /** "rgba(0, 0, 0, 0.35)" -> 35; anything else -> 0. */
    private function overlayPercent(string $css): int
    {
        return preg_match('/rgba\([^,]+,[^,]+,[^,]+,\s*([\d.]+)\)/', $css, $m) ? (int) round((float) $m[1] * 100) : 0;
    }

    private function deleteUpload(string $path): void
    {
        SafeImageUpload::delete($path, ThemeSetting::LOGIN_UPLOAD_DIR);
    }
}
