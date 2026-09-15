<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Education;
use App\Models\Blog;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Inbox;
// use App\Models\Visit_Log;

class FrontEndController extends Controller
{
    public function index()
    {
        $decode_id = base64_decode(request()->id);

        //Get User
        $user = User::getUserByUserid($decode_id);
        if(!$user) abort('404');

        $education = Education::getEducationByUserid($decode_id);
        $blog = Blog::getBlogByUserid($decode_id);
        $experience = Experience::getExperienceByUserid($decode_id);
        $project = Project::getProjectByUserid($decode_id);

        // Design chosen under Account Setting > Website Template.
        $template = $user->websiteTemplate();

        return view("website.{$template}.index", compact('user','education','blog','experience','project'));
    }

    /**
     * A single blog post. The URL ends with the user id (post/{blog}/{id})
     * because LogFrontendVisit reads the last segment.
     */
    public function post()
    {
        $decode_id = base64_decode(request()->id);

        $user = User::getUserByUserid($decode_id);
        if(!$user) abort('404');

        $post = Blog::getBlogById($user->id, (int) request()->blog);
        if(!$post) abort('404');

        $template = $user->websiteTemplate();

        // Templates without a post page show the post in their modal instead.
        if (!view()->exists("website.{$template}.post")) {
            return redirect()->to(route('front.show', request()->id).'#post-'.$post->id);
        }

        $blog = Blog::getBlogByUserid($decode_id);

        return view("website.{$template}.post", compact('user','post','blog'));
    }

    public function contact(Request $request)
    {
        $decode_id = base64_decode(request()->id);
        $user = User::getUserByUserid($decode_id);
        if(!$user) abort('404');

        $request->validate([
            'name'        => 'required|max:255',
            'email'       => 'required|email|max:255',
            'subject'     => 'nullable|max:255',
            'description' => 'required|max:5000',
        ]);

        $inbox              = new Inbox();
        $inbox->user_id     = $user->id;
        $inbox->name        = $request->name;
        $inbox->email       = $request->email;
        $inbox->subject     = $request->subject;
        $inbox->description = $request->description;
        $inbox->read_status = 0;

        $inbox->save();

        return redirect()->back()->with('success', 'Successfully Submit');

    }

}
