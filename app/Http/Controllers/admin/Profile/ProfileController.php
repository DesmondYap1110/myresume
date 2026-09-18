<?php

namespace App\Http\Controllers\admin\Profile;

use App\Http\Controllers\Controller;
use App\Support\SafeImageUpload;
use App\Support\SafeResumeUpload;
use Illuminate\Validation\ValidationException;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
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
        ], [
            'slug.regex' => 'The website address can use lowercase letters, numbers and hyphens only, for example desmond-yap.',
            'slug.not_in' => 'That website address is reserved. Please choose another one.',
            'slug.unique' => 'That website address is already taken.',
        ]);

        $user_detail->slug = $request->slug;
        $user_detail->name = $request->name;
        $user_detail->dob = date("Y-m-d",strtotime($request->dob));
        $user_detail->phone = $request->phone;
        $user_detail->role = $request->role;
        $user_detail->address = $request->address;
        $user_detail->linkedIn_url = $request->linkedIn_url;
        $user_detail->about = $request->about;

        $user_detail->update();

        return redirect()->route('profile.view')->with('success', 'Edit Successfully');

    }


    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        $user_detail = User::getUserByEmail(Auth::user()->email);

        return view(self::viewPath . 'index', compact('breadcrumbs','user_detail'));
    }


    /**
     * Uploads or replaces the resume PDF visitors can download.
     */
    public function upload_resume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:'.SafeResumeUpload::max_kb,
        ], [
            'resume.mimes' => 'Please upload your resume as a PDF file.',
            'resume.max' => 'The resume must be 5 MB or smaller.',
        ]);

        $stored = SafeResumeUpload::store($request->file('resume'));

        $user_detail = User::getUserByEmail(Auth::user()->email);
        $previous = $user_detail->resume;

        $user_detail->resume = $stored['path'];
        $user_detail->resume_name = $stored['name'];
        $user_detail->resume_uploaded_at = now();
        $user_detail->update();

        // Only remove the old file once the new one is safely recorded.
        SafeResumeUpload::delete($previous);

        return redirect()->to(route('profile.view').'#resume')->with('success', 'Resume uploaded. Visitors can now download it from your website.');
    }

    public function delete_resume()
    {
        $user_detail = User::getUserByEmail(Auth::user()->email);
        $previous = $user_detail->resume;

        $user_detail->resume = null;
        $user_detail->resume_name = null;
        $user_detail->resume_uploaded_at = null;
        $user_detail->update();

        SafeResumeUpload::delete($previous);

        return redirect()->to(route('profile.view').'#resume')->with('success', 'Resume removed from your website.');
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
