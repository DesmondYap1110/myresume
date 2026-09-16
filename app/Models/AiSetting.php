<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One user's AI Assistant settings: which provider to talk to, which model,
 * and — for the paid ones — a key, encrypted at rest and never sent back to
 * the browser. Only a masked hint is shown.
 */
class AiSetting extends Model
{
    protected $table = 'ai_setting';

    protected $fillable = ['user_id', 'provider', 'base_url', 'api_key', 'model', 'enabled', 'last_used_at'];

    protected $casts = [
        'api_key' => 'encrypted',
        'enabled' => 'boolean',
        'last_used_at' => 'datetime',
    ];

    protected $hidden = ['api_key'];

    public static function forUser($userId): self
    {
        return static::firstOrNew(['user_id' => (string) $userId]);
    }

    public function resolvedProvider(): string
    {
        $provider = $this->provider ?: (string) config('ai.default_provider', 'ollama');

        return config('ai.providers.'.$provider) ? $provider : 'ollama';
    }

    /** The chosen provider's block from config/ai.php. */
    public function providerConfig(): array
    {
        return (array) config('ai.providers.'.$this->resolvedProvider(), []);
    }

    public function providerLabel(): string
    {
        return (string) ($this->providerConfig()['label'] ?? $this->resolvedProvider());
    }

    public function needsKey(): bool
    {
        return (bool) ($this->providerConfig()['needs_key'] ?? false);
    }

    /** The key to use: this user's own, else the one in .env (Claude only). */
    public function resolvedKey(): ?string
    {
        if (!$this->needsKey()) {
            return null;
        }

        return $this->api_key ?: ($this->resolvedProvider() === 'claude' ? config('ai.api_key') : null);
    }

    public function resolvedUrl(): ?string
    {
        return $this->base_url ?: ($this->providerConfig()['default_url'] ?? null);
    }

    public function resolvedModel(): string
    {
        return $this->model ?: (string) ($this->providerConfig()['default_model'] ?? 'qwen2.5:7b');
    }

    /** Ollama needs no key, so being switched on is enough. */
    public function isReady(): bool
    {
        if (!$this->enabled) {
            return false;
        }

        return $this->needsKey() ? filled($this->resolvedKey()) : true;
    }

    /** True when this provider costs nothing to run. */
    public function isFree(): bool
    {
        return (bool) ($this->providerConfig()['free'] ?? false);
    }

    /** "sk-ant-…B2c9" — safe to show in the admin. */
    public function keyHint(): ?string
    {
        if (!$this->needsKey()) {
            return 'No key needed for this provider.';
        }

        $key = $this->api_key;

        if (blank($key)) {
            return $this->resolvedProvider() === 'claude' && filled(config('ai.api_key'))
                ? 'Using ANTHROPIC_API_KEY from .env'
                : null;
        }

        return substr($key, 0, 7).'…'.substr($key, -4);
    }
}
