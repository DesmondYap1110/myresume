<?php

namespace App\Support;

use App\Models\AiSetting;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * The AI Assistant form, shared by two screens: a member editing their own
 * settings under Account Setting, and an administrator filling them in for
 * somebody else from Member > detail. Both must validate and store the same
 * way, so the rules live here rather than in either controller.
 */
class AiSettingForm
{
    public static function rules(): array
    {
        return [
            'provider' => ['required', Rule::in(array_keys((array) config('ai.providers', [])))],
            'base_url' => ['nullable', 'string', 'max:200', 'url'],
            'api_key' => ['nullable', 'string', 'max:200', 'regex:/^[A-Za-z0-9_\-\.:]+$/'],
            'model' => ['required', 'string', 'max:120', 'regex:/^[A-Za-z0-9_\-\.\/:]+$/'],
            'model_custom' => ['nullable', 'string', 'max:120'],
            'enabled' => ['nullable', 'boolean'],
            'action' => ['nullable', 'in:save,test,remove'],
        ];
    }

    public static function messages(): array
    {
        return [
            'api_key.regex' => 'That does not look like an API key. Copy it again from your provider.',
            'base_url.url' => 'The server address must be a full URL, for example https://api.openai.com/v1',
            'model.regex' => 'That model name has characters we do not allow.',
        ];
    }

    /** "Other" in the model list means the name was typed in by hand. */
    public static function model(array $validated): string
    {
        $model = $validated['model'];

        if ($model !== '__custom') {
            return $model;
        }

        $model = trim((string) ($validated['model_custom'] ?? ''));

        if (blank($model) || !preg_match('/^[A-Za-z0-9_\-\.\/:]+$/', $model)) {
            throw ValidationException::withMessages([
                'model_custom' => 'Type the model name, using letters, numbers and - _ . / : only.',
            ]);
        }

        return $model;
    }

    /**
     * Write the submitted values onto a setting and save it. The key is only
     * replaced when one was typed, so an unchanged form keeps what is stored.
     */
    public static function apply(array $validated, AiSetting $setting, string $userId, bool $enabled, string $action = 'save'): AiSetting
    {
        $model = self::model($validated);

        $setting->user_id = $userId;

        // A key belongs to one provider; don't carry it across to another.
        if ($setting->provider && $setting->provider !== $validated['provider']) {
            $setting->api_key = null;
        }

        $setting->provider = $validated['provider'];
        $setting->base_url = $validated['base_url'] ?: null;
        $setting->model = $model;
        $setting->enabled = $enabled;

        if ($action === 'remove') {
            $setting->api_key = null;
        } elseif (filled($validated['api_key'] ?? null)) {
            $setting->api_key = $validated['api_key'];
        }

        $setting->save();

        return $setting;
    }
}
