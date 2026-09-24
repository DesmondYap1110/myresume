<?php

namespace App\Services;

use App\Models\AiSetting;
use App\Models\User;
use App\Services\Ai\AiProvider;
use App\Services\Ai\ClaudeProvider;
use App\Services\Ai\CompatibleProvider;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

/**
 * The AI Assistant behind Admin > AI Assistant.
 *
 * Two jobs:
 *  - chat()    answers questions about the owner's own portfolio data.
 *  - extract() reads an uploaded resume and returns structured data the
 *              admin can review and import.
 *
 * The work itself is done by whichever provider the user picked under
 * Account Setting > AI Assistant.
 */
class ResumeAssistant
{
    private const providers = [
        'compatible' => CompatibleProvider::class,
        'claude' => ClaudeProvider::class,
    ];

    public function __construct(private User $user)
    {
    }

    public function setting(): AiSetting
    {
        return AiSetting::forUser($this->user->id);
    }

    public function isReady(): bool
    {
        return $this->setting()->isReady();
    }

    /** The backend for this user's chosen provider. */
    public function provider(?AiSetting $setting = null): AiProvider
    {
        $setting = $setting ?: $this->setting();
        $class = self::providers[$setting->resolvedProvider()] ?? CompatibleProvider::class;

        return new $class($setting);
    }

    /**
     * Checks the settings work, using the smallest possible request.
     * Pass an unsaved AiSetting to test values the user has just typed in.
     */
    public function testConnection(?AiSetting $candidate = null): array
    {
        try {
            return $this->provider($candidate)->test();
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => $this->friendlyError($e)];
        }
    }

    /**
     * Reads a resume file and returns structured data for review.
     *
     * @return array{profile: array, experience: array, education: array, services: array, summary: string}
     */
    public function extract(UploadedFile $file): array
    {
        $data = $this->provider()->extract($file);

        $this->touch();

        return $data;
    }

    /**
     * A plain chat reply, with the user's own portfolio data as context.
     *
     * @param  array<int, array{role: string, content: string}>  $history
     */
    public function chat(array $history, string $question): string
    {
        $reply = $this->provider()->chat($history, $question, $this->portfolioContext());

        $this->touch();

        return $reply;
    }

    /**
     * The user's own data, so the assistant can answer questions about it.
     */
    private function portfolioContext(): string
    {
        $user = $this->user;
        $plain = fn ($html) => trim(preg_replace('/\s+/', ' ', strip_tags((string) $html)));

        $lines = ['Name: '.$user->name, 'Role: '.($user->role ?: '-'), 'Location: '.($user->address ?: '-')];
        $lines[] = 'About: '.($plain($user->about) ?: '-');

        $lines[] = "\nExperience:";
        foreach (\App\Models\Experience::getExperienceByUserid($user->id) as $job) {
            $lines[] = '- '.$job->role.' at '.$job->company.' ('.\App\Support\Period::label($job->start_date, $job->end_date).'): '.$plain($job->detail);
        }

        $lines[] = "\nEducation:";
        foreach (\App\Models\Education::getEducationByUserid($user->id) as $edu) {
            $lines[] = '- '.$edu->institution.', '.$edu->certificate.' '.($edu->year ?: '');
        }

        $lines[] = "\nServices:";
        foreach (\App\Models\Service::getServiceByUserid($user->id) as $service) {
            $lines[] = '- '.$service->title.': '.$service->description;
        }

        $lines[] = "\nBlog posts:";
        foreach (\App\Models\Blog::getBlogByUserid($user->id) as $post) {
            $lines[] = '- '.$post->title;
        }

        return implode("\n", $lines);
    }

    private function touch(): void
    {
        $setting = $this->setting();
        $setting->user_id = (string) $this->user->id;
        $setting->last_used_at = now();
        $setting->save();
    }

    public function friendlyError(\Throwable $e): string
    {
        $provider = $this->provider();

        if ($provider instanceof ClaudeProvider) {
            return $provider->friendlyError($e);
        }

        Log::warning('AI assistant failed', ['error' => $e->getMessage()]);

        return $e->getMessage();
    }
}
