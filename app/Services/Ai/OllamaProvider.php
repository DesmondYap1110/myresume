<?php

namespace App\Services\Ai;

use App\Support\ResumeText;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * A model running locally through Ollama — free, open source, and nothing
 * leaves the machine. Text only: PDFs are read with a parser first.
 */
class OllamaProvider extends AiProvider
{
    private function url(string $path): string
    {
        $base = rtrim($this->setting->base_url ?: (string) config('ai.providers.ollama.default_url'), '/');

        return $base.$path;
    }

    public function readsFilesDirectly(): bool
    {
        return false;
    }

    public function test(): array
    {
        try {
            $tags = Http::timeout(10)->get($this->url('/api/tags'));

            if (!$tags->successful()) {
                return ['ok' => false, 'message' => 'Ollama did not answer at '.$this->url('').'. Is it running?'];
            }

            $models = collect($tags->json('models', []))->pluck('name')->all();

            if (!in_array($this->model(), $models, true)) {
                return [
                    'ok' => false,
                    'message' => 'Ollama is running, but the model "'.$this->model().'" is not installed. Run: ollama pull '.$this->model()
                        .($models ? ' (installed: '.implode(', ', $models).')' : ''),
                ];
            }

            $reply = Http::timeout($this->timeout())->post($this->url('/api/chat'), [
                'model' => $this->model(),
                'stream' => false,
                'messages' => [['role' => 'user', 'content' => 'Reply with the single word: ready']],
            ]);

            return $reply->successful()
                ? ['ok' => true, 'message' => 'Connected to Ollama. "'.$this->model().'" answered.']
                : ['ok' => false, 'message' => 'Ollama replied with an error: '.$reply->body()];
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'Could not reach Ollama at '.$this->url('').'. Start it, then try again.'];
        }
    }

    public function chat(array $history, string $question, string $context): string
    {
        $messages = [['role' => 'system', 'content' => $this->chatSystemPrompt($context)]];

        foreach ($history as $turn) {
            $messages[] = ['role' => $turn['role'], 'content' => $turn['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $question];

        $response = Http::timeout($this->timeout())->post($this->url('/api/chat'), [
            'model' => $this->model(),
            'stream' => false,
            'messages' => $messages,
            'options' => ['temperature' => 0.4],
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('Ollama error: '.$response->body());
        }

        return trim((string) $response->json('message.content')) ?: 'Sorry, I had nothing to say. Please rephrase.';
    }

    public function extract(UploadedFile $file): array
    {
        $text = ResumeText::fromFile($file);

        if (blank($text)) {
            throw new RuntimeException(
                'No text could be read from that file. Local models cannot read scanned images — '
                .'upload a text PDF, or switch to Claude under Account Setting.'
            );
        }

        $response = Http::timeout($this->timeout())->post($this->url('/api/chat'), [
            'model' => $this->model(),
            'stream' => false,
            'format' => self::schema(),                 // Ollama structured output
            'options' => ['temperature' => 0],
            'messages' => [
                ['role' => 'system', 'content' => 'You extract structured data from resumes. Accuracy matters more than completeness: never guess. Reply with JSON only.'],
                ['role' => 'user', 'content' => $this->extractionInstructions()."\n\n--- RESUME ---\n".$text],
            ],
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('Ollama error: '.$response->body());
        }

        return $this->normalise($this->decodeJson((string) $response->json('message.content')));
    }
}
