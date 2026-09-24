<?php

/*
|--------------------------------------------------------------------------
| AI Assistant
|--------------------------------------------------------------------------
|
| Each user picks a provider under Account Setting > AI Assistant:
|
|   compatible  any OpenAI-compatible endpoint (OpenAI, OpenRouter, Groq,
|               Gemini). OpenRouter and Groq have free models; OpenAI bills.
|   claude      Anthropic's API. Paid, but reads PDFs and images directly.
|
| Both are hosted services reached over HTTPS, so they work on shared hosting
| where nothing can be installed.
|
*/

return [

    'default_provider' => env('AI_PROVIDER', 'compatible'),

    'providers' => [

        'compatible' => [
            'label' => 'OpenAI-compatible server (OpenAI, OpenRouter, Groq, Gemini)',
            'hint' => 'Point at any compatible endpoint. OpenAI is https://api.openai.com/v1; OpenRouter and Groq have free models.',
            'needs_key' => true,
            'needs_url' => true,
            'default_url' => env('AI_COMPATIBLE_URL', 'https://openrouter.ai/api/v1'),
            'default_model' => env('AI_COMPATIBLE_MODEL', 'deepseek/deepseek-chat-v3-0324:free'),
            'model_hint' => 'These services rename models often — choose Other to type the exact name they list.',
            // A starting point only — these services rename and retire models
            // often, so the form always offers "Other" for typing a name in.
            'models' => [
                'deepseek/deepseek-chat-v3-0324:free' => 'DeepSeek V3 — OpenRouter, free',
                'meta-llama/llama-3.3-70b-instruct:free' => 'Llama 3.3 70B — OpenRouter, free',
                'llama-3.3-70b-versatile' => 'Llama 3.3 70B — Groq, free tier',
                'gpt-4o-mini' => 'GPT-4o mini — OpenAI, paid, cheapest',
                'gpt-5-mini' => 'GPT-5 mini — OpenAI, paid',
                'gpt-5.1' => 'GPT-5.1 — OpenAI, paid, most capable',
            ],
            'free' => true,
        ],

        'claude' => [
            'label' => 'Claude (Anthropic) — paid, reads PDFs directly',
            'hint' => 'Get a key from console.anthropic.com. Billed by usage.',
            'needs_key' => true,
            'needs_url' => false,
            'default_url' => null,
            'default_model' => env('ANTHROPIC_MODEL', 'claude-opus-5'),
            'model_hint' => 'Opus is the most capable; Haiku costs the least.',
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

    /* Hosted models can be slow under load; allow a generous wait. */
    'timeout' => env('AI_TIMEOUT', 180),

    /* How many chat turns are kept in the session. */
    'history_turns' => 12,

];
