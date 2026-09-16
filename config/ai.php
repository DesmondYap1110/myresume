<?php

/*
|--------------------------------------------------------------------------
| AI Assistant
|--------------------------------------------------------------------------
|
| Each user picks a provider under Account Setting > AI Assistant:
|
|   ollama      free, open source, runs on your own machine. No key, no bill.
|   compatible  any OpenAI-compatible endpoint (OpenRouter, Groq, LM Studio,
|               vLLM). Several have free tiers; needs a key for hosted ones.
|   claude      Anthropic's API. Paid, but reads PDFs and images directly.
|
*/

return [

    'default_provider' => env('AI_PROVIDER', 'ollama'),

    'providers' => [

        'ollama' => [
            'label' => 'Ollama — free, runs on your computer',
            'hint' => 'Install from ollama.com, then run: ollama pull qwen2.5:7b',
            'needs_key' => false,
            'needs_url' => true,
            'default_url' => env('OLLAMA_URL', 'http://localhost:11434'),
            'default_model' => env('OLLAMA_MODEL', 'qwen2.5:7b'),
            'models' => [
                'qwen2.5:7b' => 'Qwen 2.5 7B — good all-rounder',
                'llama3.1:8b' => 'Llama 3.1 8B',
                'mistral:7b' => 'Mistral 7B',
                'gemma2:9b' => 'Gemma 2 9B',
            ],
            'free' => true,
        ],

        'compatible' => [
            'label' => 'OpenAI-compatible server (OpenRouter, Groq, LM Studio)',
            'hint' => 'Point at any compatible endpoint. OpenRouter and Groq have free models.',
            'needs_key' => true,
            'needs_url' => true,
            'default_url' => env('AI_COMPATIBLE_URL', 'https://openrouter.ai/api/v1'),
            'default_model' => env('AI_COMPATIBLE_MODEL', 'meta-llama/llama-3.3-70b-instruct:free'),
            'models' => [],           // free text: these services change often
            'free' => true,
        ],

        'claude' => [
            'label' => 'Claude (Anthropic) — paid, reads PDFs directly',
            'hint' => 'Get a key from console.anthropic.com. Billed by usage.',
            'needs_key' => true,
            'needs_url' => false,
            'default_url' => null,
            'default_model' => env('ANTHROPIC_MODEL', 'claude-opus-5'),
            'models' => [
                'claude-opus-5' => 'Claude Opus 5 — most capable',
                'claude-sonnet-5' => 'Claude Sonnet 5 — faster and cheaper',
                'claude-haiku-4-5' => 'Claude Haiku 4.5 — cheapest',
            ],
            'free' => false,
        ],

    ],

    /* Falls back to these when a user has set nothing of their own. */
    'api_key' => env('ANTHROPIC_API_KEY'),

    /* Resume uploads */
    'max_upload_mb' => 10,
    'accepted' => ['pdf', 'png', 'jpg', 'jpeg', 'webp', 'txt'],

    /* Local models are slower; allow a generous wait. */
    'timeout' => env('AI_TIMEOUT', 180),

    /* How many chat turns are kept in the session. */
    'history_turns' => 12,

];
