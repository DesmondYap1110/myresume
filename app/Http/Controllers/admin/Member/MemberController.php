<?php

namespace App\Http\Controllers\admin\Member;

use App\Helpers\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Inbox;
use App\Models\User;
use App\Models\Visit_Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Admin > Member: everyone with a portfolio on this site, and the form to add
 * another one. Accounts are blocked rather than deleted, so their pages and
 * messages are never orphaned.
 */
class MemberController extends Controller
{
    const page = "Member";
    const viewPath = "admin.template1.member.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        $members = User::orderBy('id')->get()->map(function ($user) {
            return (object) [
                'model' => $user,
                'experience' => Experience::where('user_id', $user->id)->count(),
                'education' => Education::where('user_id', $user->id)->count(),
                'blog' => Blog::where('user_id', $user->id)->count(),
                'unread' => Inbox::where('user_id', $user->id)->where('read_status', 0)->count(),
                'visits' => Visit_Log::where('user_id', $user->id)->count(),
            ];
        });

        return view(self::viewPath.'index', compact('breadcrumbs', 'members'));
    }

    public function add()
    {
        $breadcrumbs = $this->breadcrumbs->add('Add '.self::page, route($this->route.'add'))->get();

        return view(self::viewPath.'add', compact('breadcrumbs'));
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->slug = $data['slug'];
        $user->forceFill([
            'website_template' => $data['website_template'],
            'status' => $request->boolean('status'),
            'is_admin' => $request->boolean('is_admin'),
        ]);
        $user->save();

        return redirect()->route($this->route.'view')->with('success', $user->name.' can now sign in with their email address.');
    }

    public function edit()
    {
        $person = User::find(request()->id);
        if (!$person) abort(404);

        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit', $person->id))->get();

        return view(self::viewPath.'edit', compact('breadcrumbs', 'person'));
    }

    public function update(Request $request)
    {
        $person = User::find(request()->id);
        if (!$person) abort(404);

        $data = $request->validate($this->rules($person), $this->messages());

        $person->name = $data['name'];
        $person->email = $data['email'];
        $person->slug = $data['slug'];
        $person->forceFill([
            'website_template' => $data['website_template'],
            'status' => $this->guardSelf($person, 'status', $request->boolean('status')),
            'is_admin' => $this->guardSelf($person, 'is_admin', $request->boolean('is_admin')),
        ]);

        if (filled($data['password'] ?? null)) {
            $person->password = Hash::make($data['password']);
        }

        $person->save();

        return redirect()->route($this->route.'view')->with('success', $person->name.' updated.');
    }

    public function status($id)
    {
        $person = User::find($id);
        if (!$person) abort(404);

        if ($person->id === Auth::id()) {
            return redirect()->route($this->route.'view')->with('error', 'You cannot block your own account.');
        }

        $person->status = !$person->status;
        $person->save();

        return redirect()->route($this->route.'view')->with('success', $person->name.' is now '.($person->status ? 'active' : 'blocked').'.');
    }

    /**
     * Blocking yourself, or removing your own admin rights, would lock you
     * out of this screen - and possibly leave the site with no administrator.
     */
    private function guardSelf(User $person, string $field, bool $value): bool
    {
        // On your own account both stay on, whatever the form said.
        return $person->id === Auth::id() ? true : $value;
    }

    private function rules(?User $person = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email:rfc', 'max:255', Rule::unique('users', 'email')->ignore($person?->id)],
            'password' => [$person ? 'nullable' : 'required', 'string', 'min:6', 'max:255'],
            'slug' => [
                'required', 'string', 'min:3', 'max:60',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::notIn(User::reserved_slugs),
                Rule::unique('users', 'slug')->ignore($person?->id),
            ],
            'website_template' => ['required', Rule::in(array_keys((array) config('website_templates.templates', [])))],
            'status' => 'nullable|boolean',
            'is_admin' => 'nullable|boolean',
        ];
    }

    private function messages(): array
    {
        return [
            'slug.regex' => 'The website address can use lowercase letters, numbers and hyphens only, for example desmond-yap.',
            'slug.not_in' => 'That website address is reserved. Please choose another one.',
            'slug.unique' => 'That website address is already taken.',
            'email.unique' => 'Someone already signs in with that email address.',
            'password.min' => 'The password needs at least 6 characters.',
        ];
    }
}
