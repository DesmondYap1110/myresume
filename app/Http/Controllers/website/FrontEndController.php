<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Education;
use App\Models\Blog;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Inbox;
// use App\Models\Visit_Log;

class FrontEndController extends Controller
{
    public function index()
    {
        // The address is the slug (/desmond-yap), or an older base64 id (/MQ==).
        $user = User::findByRouteKey(request()->id);
        if(!$user) abort('404');

        // Send old links to the friendly one so search engines keep a single address.
        if (request()->id !== $user->routeKey()) {
            return redirect()->to(route('front.show', $user->routeKey()), 301);
        }

        $education = Education::getEducationByUserid($user->id);
        $blog = Blog::getBlogByUserid($user->id);
        $experience = Experience::getExperienceByUserid($user->id);
        $project = Project::getProjectByUserid($user->id);
        $service = Service::getServiceByUserid($user->id);
        $testimonial = Testimonial::getTestimonialByUserid($user->id);

        // Design chosen under Account Setting > Website Template.
        $template = $user->websiteTemplate();

        return view("website.{$template}.index", compact('user','education','blog','experience','project','service','testimonial'));
    }

    /**
     * A single blog post. The URL ends with the owner's key (post/{blog}/{id})
     * because LogFrontendVisit reads the last segment.
     */
    public function post()
    {
        $user = User::findByRouteKey(request()->id);
        if(!$user) abort('404');

        $post = Blog::getBlogById($user->id, (int) request()->blog);
        if(!$post) abort('404');

        if (request()->id !== $user->routeKey()) {
            return redirect()->to(route('front.post', [$post->id, $user->routeKey()]), 301);
        }

        $template = $user->websiteTemplate();

        // Templates without a post page show the post in their modal instead.
        if (!view()->exists("website.{$template}.post")) {
            return redirect()->to(route('front.show', $user->routeKey()).'#post-'.$post->id);
        }

        $blog = Blog::getBlogByUserid($user->id);

        return view("website.{$template}.post", compact('user','post','blog'));
    }

    public function contact(Request $request)
    {
        $user = User::findByRouteKey(request()->id);
        if(!$user) abort('404');

        $request->validate([
            'name'        => 'required|max:255',
            'email'       => 'required|email:rfc|max:255',
            'subject'     => 'nullable|max:255',
            'description' => 'required|min:10|max:5000',
        ]);

        // Honeypot, time trap and per-IP rate limit.
        \App\Support\SpamGuard::check($request);

        // Stored as plain text: no HTML can reach the admin screens.
        $inbox              = new Inbox();
        $inbox->user_id     = $user->id;
        $inbox->name        = \App\Support\SpamGuard::clean($request->name, 255);
        $inbox->email       = \App\Support\SpamGuard::clean($request->email, 255);
        $inbox->subject     = \App\Support\SpamGuard::clean($request->subject, 255);
        $inbox->description = \App\Support\SpamGuard::clean($request->description);
        $inbox->read_status = 0;

        $inbox->save();

        return redirect()->back()->with('success', 'Successfully Submit');

    }

}
