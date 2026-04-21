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

class FrontEndController extends Controller
{
    const viewPath  = "website.template1.";

    public function index()
    {
        $decode_id = base64_decode(request()->id);

        //Get User
        $user = User::getUserByUserid($decode_id);
        $education = Education::getEducationByUserid($decode_id);
        $blog = Blog::getBlogByUserid($decode_id);
        $experience = Experience::getExperienceByUserid($decode_id);
        $project = Project::getProjectByUserid($decode_id);

        if(!$user) abort('404');

        return view(self::viewPath . 'index',compact('user','education','blog','experience','project'));
    }

    public function contact(Request $request)
    {
        $decode_id = base64_decode(request()->id);
        $user = User::getUserByUserid($decode_id);

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
