<?php

namespace App\Services\Ai;

use App\Models\AiSetting;
use Illuminate\Http\UploadedFile;

/**
 * One AI backend. Every provider answers chat questions and reads a resume
 * into the same structured shape, so the rest of the app never cares which
 * one is in use.
 */
abstract class AiProvider
{
    public function __construct(protected AiSetting $setting)
    {
    }

    /** A short reply to a question, with the portfolio as context. */
    abstract public function chat(array $history, string $question, string $context): string;

    /** Structured resume data, or throws. */
    abstract public function extract(UploadedFile $file): array;

    /** ['ok' => bool, 'message' => string] */
    abstract public function test(): array;

    /** Whether this provider can read a file the app cannot turn into text. */
    abstract public function readsFilesDirectly(): bool;

    protected function model(): string
    {
        return $this->setting->resolvedModel();
    }

    protected function timeout(): int
    {
        return (int) config('ai.timeout', 180);
    }

    /** The shape every provider must return from extract(). */
    public static function schema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'profile' => [
                    'type' => 'object',
                    'properties' => [
                        'name' => ['type' => ['string', 'null']],
                        'role' => ['type' => ['string', 'null'], 'description' => 'Current job title'],
                        'address' => ['type' => ['string', 'null'], 'description' => 'City and country only'],
                        'email' => ['type' => ['string', 'null']],
                        'phone' => ['type' => ['string', 'null'], 'description' => 'Digits with country code'],
                        'linkedIn_url' => ['type' => ['string', 'null'], 'description' => 'The full https:// address, or null when only the words "LinkedIn" appear'],
                        'about' => ['type' => ['string', 'null'], 'description' => 'Professional summary, 2-4 sentences, plus listed skills'],
                    ],
                    'required' => ['name', 'role', 'address', 'email', 'phone', 'linkedIn_url', 'about'],
                    'additionalProperties' => false,
                ],
                'experience' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'company' => ['type' => 'string'],
                            'role' => ['type' => 'string'],
                            'start_date' => ['type' => 'string', 'description' => 'YYYY-MM if the month is given, else YYYY'],
                            'end_date' => ['type' => ['string', 'null'], 'description' => 'Same format, null for the current job'],
                            'bullets' => ['type' => 'array', 'items' => ['type' => 'string']],
                        ],
                        'required' => ['company', 'role', 'start_date', 'end_date', 'bullets'],
                        'additionalProperties' => false,
                    ],
                ],
                'education' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'institution' => ['type' => 'string'],
                            'certificate' => ['type' => 'string'],
                            'year' => ['type' => ['integer', 'null']],
                            'achievement' => ['type' => ['string', 'null']],
                        ],
                        'required' => ['institution', 'certificate', 'year', 'achievement'],
                        'additionalProperties' => false,
                    ],
                ],
                'services' => [
                    'type' => 'array',
                    'description' => 'At most 4 services this person could offer, based on their skills',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'title' => ['type' => 'string'],
                            'description' => ['type' => 'string'],
                            'icon' => [
                                'type' => 'string',
                                'enum' => ['code', 'web', 'mobile', 'database', 'api', 'design', 'security', 'cloud', 'chart', 'support', 'rocket', 'gear'],
                                'description' => 'The closest match for this service',
                            ],
                        ],
                        'required' => ['title', 'description', 'icon'],
                        'additionalProperties' => false,
                    ],
                ],
                'summary' => ['type' => 'string', 'description' => 'One or two sentences telling the user what was found'],
            ],
            'required' => ['profile', 'experience', 'education', 'services', 'summary'],
            'additionalProperties' => false,
        ];
    }

    protected function extractionInstructions(): string
    {
        return "Read this resume and extract the person's details.\n\n"
            ."Rules:\n"
            ."- Copy only what the document says. Never invent an employer, date, qualification or skill.\n"
            ."- Use null when something is not in the document.\n"
            ."- Dates: YYYY-MM only when the month is written, otherwise YYYY.\n"
            ."- end_date is null for the person's current role.\n"
            ."- Bullets: keep the resume's wording, one responsibility per bullet, no invented numbers.\n"
            ."- Services: at most 4, based on the skills actually shown.\n"
            ."- Fix obvious typos.\n"
            ."- summary: one or two sentences saying what you found.";
    }

    protected function chatSystemPrompt(string $context): string
    {
        return "You are the assistant inside MyResume, a portfolio admin. You help the owner write and improve "
            ."their portfolio: summaries, job descriptions, service wording, blog ideas and wording fixes.\n\n"
            ."Keep answers short and practical. When asked to write something, give the text itself.\n"
            ."You cannot change the database; say which admin page to paste the text into.\n"
            ."To import a resume, tell the user to attach the file to this chat.\n\n"
            ."The owner's portfolio as it stands:\n".$context;
    }

    /**
     * Pulls the JSON object out of a model reply that may be wrapped in prose
     * or ```json fences — smaller models often do that.
     */
    protected function decodeJson(string $text): array
    {
        $text = trim($text);
        $text = preg_replace('/^```(?:json)?|```$/mi', '', $text);

        $data = json_decode(trim($text), true);

        if (is_array($data)) {
            return $data;
        }

        $start = strpos($text, '{');
        $end = strrpos($text, '}');

        if ($start !== false && $end !== false && $end > $start) {
            $data = json_decode(substr($text, $start, $end - $start + 1), true);

            if (is_array($data)) {
                return $data;
            }
        }

        throw new \RuntimeException('The model did not return readable data. Try again, or pick a larger model.');
    }

    /** Fills in anything a smaller model left out, so the UI never breaks. */
    protected function normalise(array $data): array
    {
        return [
            'profile' => (array) ($data['profile'] ?? []),
            'experience' => array_values(array_filter((array) ($data['experience'] ?? []), 'is_array')),
            'education' => array_values(array_filter((array) ($data['education'] ?? []), 'is_array')),
            'services' => array_values(array_filter((array) ($data['services'] ?? []), 'is_array')),
            'summary' => (string) ($data['summary'] ?? 'I read the resume — check the panel on the right.'),
        ];
    }
}
