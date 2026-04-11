<?php

namespace App\Http\Controllers\admin\Experience;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Experience;

class ExperienceController extends Controller
{
    const page ="Experience";
    const viewPath = "admin.template1.experience.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function add()
    {
        $breadcrumbs = $this->breadcrumbs->add('Add '.self::page, route($this->route.'add'))->get();

        return view(self::viewPath . 'add', compact('breadcrumbs'));
    }

    public function edit()
    {
        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit',request()->id))->get();
        $experience  = Experience::getExperienceById(Auth::id(),request()->id);

        return view(self::viewPath . 'edit', compact('breadcrumbs','experience'));
    }

    public function create(Request $request)
    {
        $experience              = new Experience();
        $experience->user_id     = Auth::id();
        $experience->company     = $request->company;
        $experience->role        = $request->role;
        $experience->start_date  = date("Y-m-d",strtotime($request->start_date));
        $experience->end_date    = date("Y-m-d",strtotime($request->end_date));
        $experience->detail      = $request->detail;
        $experience->save();

       return redirect()->route('experience.view')->with('success', 'Add Experience successful!');
    }

    public function update(Request $request)
    {
        $experience_detail              = Experience::getExperienceById(Auth::id(),request()->id);
        $experience_detail->company     = $request->company;
        $experience_detail->role        = $request->role;
        $experience_detail->start_date  = date("Y-m-d",strtotime($request->start_date));
        $experience_detail->end_date    = date("Y-m-d",strtotime($request->end_date));
        $experience_detail->detail      = $request->detail;
        $experience_detail->update();

        return redirect()->route('experience.view')->with('success', 'Edit Experience successful!');
    }

    public function delete()
    {

        $experience_detail = Experience::getExperienceById(Auth::id(),request()->id);
        $experience_detail->delete();

        return redirect()->route('experience.view')->with('success', 'Delete Experience successful!');

    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        $experience  = Experience::getExperienceByUserid(Auth::id(),request()->id);

        return view(self::viewPath . 'index', compact('breadcrumbs','experience'));
    }
}
