<?php

namespace App\Http\Controllers\admin\AiSetting;

use App\Helpers\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Models\AiSetting;
use App\Models\User;
use App\Services\ResumeAssistant;
use App\Support\AiSettingForm;
use Illuminate\Http\Request;

/**
 * Admin > AI Setting: every member's AI Assistant configuration in one place,
 * so an administrator can see who has a key and fill one in for whoever
 * cannot work out where it goes.
 *
 * Members still set their own under Account Setting > AI Assistant; this is
 * the same settings, reached from the other side.
 */
class AiSettingController extends Controller
{
    const page = "AI Setting";
    const viewPath = "admin.template1.aisetting.";

    protected $breadcrumbs;
    protected $route = "aisetting.";

    public function __construct()
    {
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        $members = User::orderBy('id')->get();

        // One query for everyone's settings, keyed by user, so the table costs
        // the same whether there are three members or three hundred.
        $settings = AiSetting::all()->keyBy(fn ($s) => (string) $s->user_id);

        return view(self::viewPath.'index', compact('breadcrumbs', 'members', 'settings'));
    }

    public function edit($id)
    {
        $person = User::find($id);
        if (!$person) abort(404);

        $breadcrumbs = $this->breadcrumbs->add($person->name, route($this->route.'edit', $person->id))->get();

        $setting = AiSetting::forUser($person->id);
        $providers = (array) config('ai.providers', []);

        return view(self::viewPath.'edit', compact('breadcrumbs', 'person', 'setting', 'providers'));
    }

    public function update(Request $request, $id)
    {
        $person = User::find($id);
        if (!$person) abort(404);

        $validated = $request->validate(AiSettingForm::rules(), AiSettingForm::messages());
        $action = (string) $request->input('action', 'save');

        $setting = AiSettingForm::apply(
            $validated,
            AiSetting::forUser($person->id),
            (string) $person->id,
            $request->boolean('enabled'),
            $action
        );

        if ($action === 'remove') {
            return redirect()->route($this->route.'view')
                ->with('success', __('admin.flash.key_removed_for', ['name' => $person->name]));
        }

        // Testing stays on the form, so the settings just tried are still there
        // to correct if the provider refused them.
        if ($action === 'test') {
            $result = (new ResumeAssistant($person))->testConnection($setting);

            return redirect()->route($this->route.'edit', $person->id)
                ->with($result['ok'] ? 'success' : 'error', $result['message']);
        }

        return redirect()->route($this->route.'view')
            ->with('success', __('admin.flash.ai_saved_for', ['name' => $person->name]));
    }
}
