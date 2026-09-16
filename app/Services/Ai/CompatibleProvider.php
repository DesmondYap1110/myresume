<?php

namespace App\Services\Ai;

use App\Support\ResumeText;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Any OpenAI-compatible chat endpoint: OpenRouter and Groq (both have free
 * models), LM Studio, vLLM, llama.cpp, Together, and so on.
 */
class CompatibleProvider extends AiProvider
{
    private function url(string $path): string
    {
        $base = rtrim($this->setting->base_url ?: (string) config('ai.providers.compatible.default_url'), '/');

        // Accept a base with or without /v1 on the end.
        return $base.$path;
    }

    private function request()
    {
        $key = $this->setting->resolvedKey();

        return Http::timeout($this->timeout())
            ->withHeaders(array_filter([
                'Authorization' => $key ? 'Bearer '.$key : null,
                'HTTP-Referer' => config('app.url'),      // OpenRouter asks for these
                'X-Title' => 'MyResume',
            ]));
    }

    public function readsFilesDirectly(): bool
    {
        return false;
    }

    public function test(): array
    {
        try {
            $response = $this->request()->post($this->url('/chat/completions'), [
                'model' => $this->model(),
                'max_tokens' => 16,
                'messages' => [['role' => 'user', 'content' => 'Reply with the single word: ready']],
            ]);

            if ($response->successful()) {
                return ['ok' => true, 'message' => 'Connected. "'.$this->model().'" answered.'];
            }

            return ['ok' => false, 'message' => $this->explain($response)];
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'Could not reach '.$this->url('').' — '.$e->getMessage()];
        }
    }

    /**
     * These servers answer with a JSON error body. Show the sentence inside it,
     * not the whole blob, and say what to do about the usual ones.
     */
    private function explain(\Illuminate\Http\Client\Response $response): string
    {
        $detail = $response->json('error.message')
            ?: $response->json('message')
            ?: \Illuminate\Support\Str::limit($response->body(), 200);

        $code = $response->json('error.code');

        return match (true) {
            $response->status() === 401 => 'That API key was rejected. Check it under Account Setting > AI Assistant.',
            $code === 'insufficient_quota', $code === 'credit_balance_exhausted' => 'This account is out of credit: '.$detail,
            $response->status() === 429 => 'Too many requests, or no credit left: '.$detail,
            $response->status() === 404 => 'The model "'.$this->model().'" was not found on this server. Check the name, or pick another.',
            default => 'The AI server replied '.$response->status().': '.$detail,
        };
    }

    public function chat(array $history, string $question, string $context): string
    {
        $messages = [['role' => 'system', 'content' => $this->chatSystemPrompt($context)]];

        foreach ($history as $turn) {
            $messages[] = ['role' => $turn['role'], 'content' => $turn['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $question];

        $response = $this->request()->post($this->url('/chat/completions'), [
            'model' => $this->model(),
            'messages' => $messages,
            'temperature' => 0.4,
            'max_tokens' => 1500,
        ]);

        if (!$response->successful()) {
            throw new RuntimeException($this->explain($response));
        }

        return trim((string) $response->json('choices.0.message.content')) ?: 'Sorry, I had nothing to say. Please rephrase.';
    }

    public function extract(UploadedFile $file): array
    {
        $text = ResumeText::fromFile($file);

        if (blank($text)) {
            throw new RuntimeException('No text could be read from that file. Upload a text PDF, or switch to Claude which reads images.');
        }

        $messages = [
            ['role' => 'system', 'content' => 'You extract structured data from resumes. Accuracy matters more than completeness: never guess. Reply with JSON only, matching the requested shape.'],
            ['role' => 'user', 'content' => $this->extractionInstructions()
                ."\n\nReturn JSON matching this schema:\n".json_encode(self::schema())
                ."\n\n--- RESUME ---\n".$text],
        ];

        $payload = [
            'model' => $this->model(),
            'messages' => $messages,
            'temperature' => 0,
            'max_tokens' => 4000,
            'response_format' => [
                'type' => 'json_schema',
                'json_schema' => ['name' => 'resume', 'strict' => true, 'schema' => self::schema()],
            ],
        ];

        $response = $this->request()->post($this->url('/chat/completions'), $payload);

        // Not every server supports json_schema; fall back to plain JSON mode.
        // Only worth retrying when the schema itself was the problem.
        if ($response->status() === 400) {
            $payload['response_format'] = ['type' => 'json_object'];
            $response = $this->request()->post($this->url('/chat/completions'), $payload);
        }

        if (!$response->successful()) {
            throw new RuntimeException($this->explain($response));
        }

        return $this->normalise($this->decodeJson((string) $response->json('choices.0.message.content')));
    }
}
