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

        return back()->with('success', $templates[$request->website_template]['name'].' is now live on your website!');
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $templates = (array) config('website_templates.templates', []);
        $currentTemplate = Auth::user()->websiteTemplate();

        return view(self::viewPath . 'index', compact('breadcrumbs', 'templates', 'currentTemplate'));
    }
}
