<?php

namespace App\Http\Controllers\admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\SavesTranslations;
use App\Support\SafeImageUpload;
use App\Services\ResumePdf;
use Illuminate\Validation\ValidationException;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    use SavesTranslations;
    const page ="Profile";
    const viewPath = "admin.template1.profile.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function update(Request $request)
    {
        $user_detail = User::getUserByEmail(Auth::user()->email);

        // The website address, e.g. /desmond-yap
        $request->validate([
            'slug' => [
                'required', 'string', 'min:3', 'max:60',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::notIn(User::reserved_slugs),
                Rule::unique('users', 'slug')->ignore($user_detail->id),
            ],
            // Empty is allowed and means "follow the visitor's browser".
            'default_locale' => ['nullable', 'string', Rule::in(array_keys((array) config('locales.supported', [])))],
            'social' => ['array'],
            'social.*.url' => ['nullable', 'string', 'max:300'],
            'social_custom' => ['array', 'max:'.\App\Support\SocialLinks::maxCustom],
            'social_custom.*.label' => ['nullable', 'string', 'max:40'],
            'social_custom.*.url' => ['nullable', 'string', 'max:300', 'url'],
        ], [
            'slug.regex' => 'The website address can use lowercase letters, numbers and hyphens only, for example desmond-yap.',
            'slug.not_in' => 'That website address is reserved. Please choose another one.',
            'slug.unique' => 'That website address is already taken.',
        ]);

        // A known network's link has to be on that network's own domain, so a
        // lookalike address cannot be passed off as a real profile.
        foreach ((array) $request->input('social', []) as $key => $row) {
            $url = trim((string) ($row['url'] ?? ''));

            if ($url === '') {
                continue;
            }

            $hosts = (array) config("social.networks.$key.host", []);

            if (!\App\Support\SocialLinks::valid($url, $hosts)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "social.$key.url" => \App\Support\SocialLinks::hostMessage($key),
                ]);
            }
        }

        $user_detail->slug = $request->slug;
        $user_detail->name = $request->name;
        $user_detail->dob = date("Y-m-d",strtotime($request->dob));
        // The phone number is the digits of the WhatsApp link, so it is asked
        // for once. An empty WhatsApp row leaves whatever is already stored,
        // rather than wiping a number the resume and contact block still use.
        $whatsapp = preg_replace('/\D+/', '', (string) $request->input('social.whatsapp.url', ''));

        if ($whatsapp !== '') {
            $user_detail->phone = $whatsapp;
        }
        $user_detail->role = $request->role;
        $user_detail->address = $request->address;

        // Null rather than '' so the column reads as "not set" in the database
        // as well as in the form.
        $user_detail->default_locale = $request->input('default_locale') ?: null;

        /*
         * Drop any language this browser picked earlier on the public site.
         *
         * SetLocale reads the visitor's own choice before the owner's default,
         * which is right for a visitor but meant the owner saw no change after
         * setting this - their session still held whatever they last switched
         * to, so the setting looked broken.
         */
        $request->session()->forget(\App\Http\Middleware\SetLocale::key);

        $user_detail->about = $request->about;

        // Kept in step with the Social Links row, because the resume and the
        // member list still read this column.
        $user_detail->linkedIn_url = trim((string) $request->input('social.linkedin.url', '')) ?: null;

        $user_detail->social_links = \App\Support\SocialLinks::fromRequest(
            (array) $request->input('social', []),
            (array) $request->input('social_custom', [])
        ) ?: null;

        $user_detail->update();

        $this->storeTranslations($request, $user_detail);

        return redirect()->route('profile.view')->with('success', __('admin.flash.profile_saved'));

    }


    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        $user_detail = User::getUserByEmail(Auth::user()->email);

        // What the generated resume will contain, shown on its card.
        $resumeStats = [
            'experience' => \App\Models\Experience::getExperienceByUserid($user_detail->id)->count(),
            'education' => \App\Models\Education::getEducationByUserid($user_detail->id)->count(),
            'services' => \App\Models\Service::getServiceByUserid($user_detail->id)->count(),
            'projects' => \App\Models\Project::getProjectByUserid($user_detail->id)->count(),
        ];

        return view(self::viewPath . 'index', compact('breadcrumbs','user_detail','resumeStats'));
    }


    /**
     * The resume, generated from the profile data. Opens in the browser to
     * preview; ?download=1 saves it instead.
     */
    public function resume(Request $request)
    {
        $user_detail = User::getUserByEmail(Auth::user()->email);
        $pdf = ResumePdf::for($user_detail);

        return $pdf->response($request->boolean('download') ? 'attachment' : 'inline');
    }

// Controller
    public function upload_img(Request $request)
    {
        try
        {
            $request->validate([
                'uploadImg' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
            ]);

            $path = SafeImageUpload::store($request->file('uploadImg'), 'uploads', 'uploadImg');

            $user_detail = User::getUserByEmail(Auth::user()->email);
            // Stored as a path so it works on any host; User::getImageAttribute builds the URL.
            $user_detail->image = $path;
            $user_detail->update();

            return response()->json([
                'success' => true,
                'url' => asset($path)
            ]);
        }
        catch (ValidationException $e)
        {
            return response()->json(['success' => false,'message' => collect($e->errors())->flatten()->first()], 422);
        }
        catch (\Exception $e)
        {
            return response()->json(['success' => false,'message' => $e->getMessage()], 500);
        }
    }

}
