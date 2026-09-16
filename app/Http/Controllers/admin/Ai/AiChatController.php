<?php

namespace App\Http\Controllers\admin\Ai;

use App\Helpers\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Services\ResumeAssistant;
use App\Services\ResumeImporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Admin > AI Assistant: a chat with the user's chosen AI, which can also read
 * an uploaded resume and fill in their profile, experience, education and
 * services.
 */
class AiChatController extends Controller
{
    const page = "Ai";
    const viewPath = "admin.template1.ai.";

    /** Session keys. */
    private const historyKey = 'ai.history';
    private const draftKey = 'ai.draft';

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage('AI Assistant', route($this->route.'view'));
    }

    private function assistant(): ResumeAssistant
    {
        return new ResumeAssistant(Auth::user());
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $assistant = $this->assistant();

        return view(self::viewPath.'index', [
            'breadcrumbs' => $breadcrumbs,
            'ready' => $assistant->isReady(),
            'model' => $assistant->setting()->resolvedModel(),
            'providerLabel' => $assistant->setting()->providerLabel(),
            'readsFiles' => $assistant->provider()->readsFilesDirectly(),
            'history' => session(self::historyKey, []),
            'draft' => session(self::draftKey),
            'maxUploadMb' => (int) config('ai.max_upload_mb', 10),
            'accepted' => (array) config('ai.accepted', []),
        ]);
    }

    /**
     * One chat turn. A message, a file, or both.
     */
    public function message(Request $request): JsonResponse
    {
        $accepted = implode(',', (array) config('ai.accepted', ['pdf']));

        $request->validate([
            'message' => 'nullable|string|max:4000',
            'resume' => 'nullable|file|mimes:'.$accepted.'|max:'.((int) config('ai.max_upload_mb', 10) * 1024),
        ]);

        if (blank($request->input('message')) && !$request->hasFile('resume')) {
            return response()->json(['ok' => false, 'error' => 'Type a message or attach a resume file.'], 422);
        }

        $assistant = $this->assistant();

        if (!$assistant->isReady()) {
            return response()->json([
                'ok' => false,
                'error' => 'The assistant is not set up yet. Choose a provider under Account Setting > AI Assistant.',
            ], 422);
        }

        // A small cap so a stuck page cannot run up an API bill.
        $key = 'ai-chat:'.Auth::id();

        if (RateLimiter::tooManyAttempts($key, 30)) {
            return response()->json(['ok' => false, 'error' => 'That is a lot of requests. Please wait a minute.'], 429);
        }

        RateLimiter::hit($key, 60);

        try {
            if ($request->hasFile('resume')) {
                $data = $assistant->extract($request->file('resume'));

                session([self::draftKey => $data]);

                $reply = $data['summary'] ?? 'I read the resume.';

                $this->remember('user', trim(($request->input('message') ?: 'Here is my resume.').' ['.$request->file('resume')->getClientOriginalName().']'));
                $this->remember('assistant', $reply);

                return response()->json([
                    'ok' => true,
                    'reply' => $reply,
                    'draft' => $this->draftPreview($data),
                ]);
            }

            $reply = $assistant->chat(session(self::historyKey, []), $request->input('message'));

            $this->remember('user', $request->input('message'));
            $this->remember('assistant', $reply);

            return response()->json(['ok' => true, 'reply' => $reply]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => $assistant->friendlyError($e)], 500);
        }
    }

    /**
     * Writes the reviewed parts of the last read resume into the modules.
     */
    public function import(Request $request)
    {
        $request->validate([
            'sections' => 'required|array|min:1',
            'sections.*' => 'in:profile,experience,education,services',
        ]);

        $draft = session(self::draftKey);

        if (!is_array($draft)) {
            return back()->with('error', 'Nothing to import. Please upload the resume again.');
        }

        $done = (new ResumeImporter(Auth::user()))->import($draft, $request->input('sections'));

        session()->forget(self::draftKey);

        $parts = [];
        if ($done['profile']) $parts[] = $done['profile'].' profile field'.($done['profile'] > 1 ? 's' : '');
        if ($done['experience']) $parts[] = $done['experience'].' job'.($done['experience'] > 1 ? 's' : '');
        if ($done['education']) $parts[] = $done['education'].' qualification'.($done['education'] > 1 ? 's' : '');
        if ($done['services']) $parts[] = $done['services'].' service'.($done['services'] > 1 ? 's' : '');

        return redirect()->route($this->route.'view')
            ->with('success', $parts ? 'Imported '.implode(', ', $parts).'.' : 'Nothing was imported.');
    }

    public function clear()
    {
        session()->forget([self::historyKey, self::draftKey]);

        return redirect()->route($this->route.'view')->with('success', 'Chat cleared.');
    }

    /** Keeps the last few turns so the conversation has context. */
    private function remember(string $role, string $content): void
    {
        $history = session(self::historyKey, []);
        $history[] = ['role' => $role, 'content' => $content];

        session([self::historyKey => array_slice($history, -1 * (int) config('ai.history_turns', 12))]);
    }

    /** A short, human summary of what would be imported. */
    private function draftPreview(array $data): array
    {
        return [
            'profile' => collect($data['profile'] ?? [])->filter(fn ($v) => filled($v))->keys()->all(),
            'experience' => collect($data['experience'] ?? [])->map(fn ($j) => trim(($j['role'] ?? '').' at '.($j['company'] ?? '')))->all(),
            'education' => collect($data['education'] ?? [])->map(fn ($e) => trim(($e['certificate'] ?? '').' — '.($e['institution'] ?? '')))->all(),
            'services' => collect($data['services'] ?? [])->pluck('title')->all(),
        ];
    }
}
