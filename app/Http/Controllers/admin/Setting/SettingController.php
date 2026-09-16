<?php

namespace App\Http\Controllers\admin\Setting;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class SettingController extends Controller
{
    const page ="Setting";
    const viewPath = "admin.template1.setting.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirmpassword' => 'required'
        ]);

        // Manual check for password match
        if ($request->password !== $request->confirmpassword)
        {
            return back()->with('error', 'The password confirmation does not match.')->withInput();
        }

        $user = User::getUserByEmail(Auth::user()->email);
        $user->password = bcrypt($request->password);
        $user->update();

        return back()->with('success', 'Password updated successfully!');
    }
    /**
     * Website Template: which public design this user's portfolio uses.
     */
    public function template(Request $request)
    {
        $templates = (array) config('website_templates.templates', []);

        $request->validate([
            'website_template' => ['required', Rule::in(array_keys($templates))],
        ], [
            'website_template.in' => 'Please choose one of the available templates.',
        ]);

        $user = User::getUserByEmail(Auth::user()->email);
        $user->website_template = $request->website_template;
        $user->update();

        return redirect()->to(route('setting.view').'#template')
            ->with('success', $templates[$request->website_template]['name'].' is now live on your website!');
    }

    /**
     * AI Assistant settings: which provider to use, its address and model,
     * and — for the paid ones — a key, stored encrypted and never sent back
     * to the browser.
     */
    public function ai(Request $request)
    {
        $providers = (array) config('ai.providers', []);

        $validated = $request->validate([
            'provider' => ['required', Rule::in(array_keys($providers))],
            'base_url' => ['nullable', 'string', 'max:200', 'url'],
            'api_key' => ['nullable', 'string', 'max:200', 'regex:/^[A-Za-z0-9_\-\.:]+$/'],
            'model' => ['required', 'string', 'max:120', 'regex:/^[A-Za-z0-9_\-\.\/:]+$/'],
            'model_custom' => ['nullable', 'string', 'max:120'],
            'enabled' => ['nullable', 'boolean'],
            'action' => ['nullable', 'in:save,test,remove'],
        ], [
            'api_key.regex' => 'That does not look like an API key. Copy it again from your provider.',
            'base_url.url' => 'The server address must be a full URL, for example http://localhost:11434',
            'model.regex' => 'That model name has characters we do not allow.',
        ]);

        // "Other" in the model list means the name was typed in by hand.
        $model = $validated['model'];

        if ($model === '__custom') {
            $model = trim((string) ($validated['model_custom'] ?? ''));

            if (blank($model) || !preg_match('/^[A-Za-z0-9_\-\.\/:]+$/', $model)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'model_custom' => 'Type the model name, using letters, numbers and - _ . / : only.',
                ]);
            }
        }

        $setting = \App\Models\AiSetting::forUser(Auth::id());
        $setting->user_id = (string) Auth::id();
        $changingProvider = $setting->provider && $setting->provider !== $validated['provider'];
        $setting->provider = $validated['provider'];
        $setting->base_url = $validated['base_url'] ?: null;
        $setting->model = $model;
        $setting->enabled = $request->boolean('enabled');

        // A key belongs to one provider; don't carry it across to another.
        if ($changingProvider) {
            $setting->api_key = null;
        }

        if ($request->input('action') === 'remove') {
            $setting->api_key = null;
            $setting->save();

            return redirect()->to(route('setting.view').'#ai')->with('success', 'API key removed.');
        }

        if (filled($validated['api_key'] ?? null)) {
            $setting->api_key = $validated['api_key'];
        }

        $setting->save();

        if ($request->input('action') === 'test') {
            $result = (new \App\Services\ResumeAssistant(Auth::user()))->testConnection($setting);

            return redirect()->to(route('setting.view').'#ai')
                ->with($result['ok'] ? 'success' : 'error', $result['message']);
        }

        return redirect()->to(route('setting.view').'#ai')->with('success', 'AI settings saved.');
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $templates = (array) config('website_templates.templates', []);
        $currentTemplate = Auth::user()->websiteTemplate();
        $aiSetting = \App\Models\AiSetting::forUser(Auth::id());
        $aiProviders = (array) config('ai.providers', []);

        // Password, Website Template and Theme Setting all live on this page.
        return view(self::viewPath . 'index', array_merge(
            compact('breadcrumbs', 'templates', 'currentTemplate', 'aiSetting', 'aiProviders'),
            \App\Support\ThemeSettingData::forView(),
        ));
    }
}
