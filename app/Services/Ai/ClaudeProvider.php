<?php

namespace App\Services\Ai;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Messages\Base64PDFSource;
use Anthropic\Messages\DocumentBlockParam;
use Illuminate\Http\UploadedFile;
use RuntimeException;

/**
 * Anthropic's API. Paid, but it reads PDFs and photographed resumes directly,
 * so nothing has to be turned into text first.
 */
class ClaudeProvider extends AiProvider
{
    public function readsFilesDirectly(): bool
    {
        return true;
    }

    private function client(?string $key = null): Client
    {
        $key = $key ?: $this->setting->resolvedKey();

        if (blank($key)) {
            throw new RuntimeException('No API key yet. Add one under Account Setting > AI Assistant.');
        }

        return new Client(apiKey: $key);
    }

    public function test(): array
    {
        try {
            $this->client()->messages->create(
                model: $this->model(),
                maxTokens: 16,
                messages: [['role' => 'user', 'content' => 'Reply with the word: ready']],
            );

            return ['ok' => true, 'message' => 'Connected. The key works.'];
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => $this->friendlyError($e)];
        }
    }

    public function chat(array $history, string $question, string $context): string
    {
        $messages = [];

        foreach ($history as $turn) {
            $messages[] = ['role' => $turn['role'], 'content' => $turn['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $question];

        $message = $this->client()->messages->create(
            model: $this->model(),
            maxTokens: 4000,
            system: [[
                'type' => 'text',
                'text' => $this->chatSystemPrompt($context),
                'cacheControl' => ['type' => 'ephemeral'],
            ]],
            messages: $messages,
        );

        $reply = '';

        foreach ($message->content as $block) {
            if ($block->type === 'text') {
                $reply .= $block->text;
            }
        }

        return trim($reply) ?: 'Sorry, I had nothing to say to that. Please try rephrasing.';
    }

    public function extract(UploadedFile $file): array
    {
        $content = [
            $this->fileBlock($file),
            ['type' => 'text', 'text' => $this->extractionInstructions()],
        ];

        $message = $this->client()->messages->create(
            model: $this->model(),
            maxTokens: 16000,
            system: 'You extract structured data from resumes for a portfolio website. Accuracy matters more than completeness: never guess.',
            messages: [['role' => 'user', 'content' => $content]],
            outputConfig: ['format' => ['type' => 'json_schema', 'schema' => self::schema()]],
        );

        foreach ($message->content as $block) {
            if ($block->type === 'text') {
                return $this->normalise($this->decodeJson($block->text));
            }
        }

        throw new RuntimeException('The assistant did not return readable data. Please try again.');
    }

    /**
     * A resume file as a message block: PDFs as documents, pictures as images,
     * plain text inline.
     */
    private function fileBlock(UploadedFile $file): DocumentBlockParam|array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $data = base64_encode(file_get_contents($file->getRealPath()));

        if ($extension === 'pdf') {
            return DocumentBlockParam::with(
                source: Base64PDFSource::with($data),
                title: $file->getClientOriginalName(),
            );
        }

        if ($extension === 'txt') {
            return ['type' => 'text', 'text' => "Resume text:\n\n".mb_substr(file_get_contents($file->getRealPath()), 0, 100000)];
        }

        return [
            'type' => 'image',
            'source' => [
                'type' => 'base64',
                'media_type' => $file->getMimeType() ?: 'image/png',
                'data' => $data,
            ],
        ];
    }

    public function friendlyError(\Throwable $e): string
    {
        if ($e instanceof APIStatusException) {
            return match ($e->type?->value) {
                'authentication_error' => 'That API key was rejected. Check it under Account Setting > AI Assistant.',
                'permission_error' => 'This key is not allowed to use that model. Try Claude Sonnet 5, or check your Anthropic plan.',
                'rate_limit_error' => 'Anthropic is rate limiting this key. Please wait a moment and try again.',
                'overloaded_error' => 'Anthropic is busy right now. Please try again shortly.',
                'invalid_request_error' => 'The request was rejected: '.$e->getMessage(),
                default => 'The assistant could not be reached: '.$e->getMessage(),
            };
        }

        return $e->getMessage();
    }
}
