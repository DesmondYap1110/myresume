<?php

namespace App\Http\Controllers\admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\SavesTranslations;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ProjectController extends Controller
{
    use SavesTranslations;
    const page ="Project";
    const viewPath = "admin.template1.project.";

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


    public function edit(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit',request()->id))->get();
        $project_detail  = Project::getProjectById(Auth::id(),request()->id);
        if(!$project_detail) abort(404);

        return view(self::viewPath . 'edit', compact('breadcrumbs','project_detail'));
    }


    public function create(Request $request)
    {
        $project = new Project();
        $project->user_id     = Auth::id();
        $project->name        = $request->name;
        $project->company     = $request->company;
        $project->start_date  = $request->start_date;
        $project->end_date    = $request->end_date;
        $project->detail      = $request->detail;
        $project->save();

        $this->storeTranslations($request, $project);

       return redirect()->route('project.view')->with('success', __('admin.flash.added', ['item' => __('admin.menu.project')]));
    }

    public function update(Request $request)
    {
        $project_detail              = Project::getProjectById(Auth::id(),request()->id);
        $project_detail->name        = $request->name;
        $project_detail->company     = $request->company;
        $project_detail->start_date  = $request->start_date;
        $project_detail->end_date    = $request->end_date;
        $project_detail->detail      = $request->detail;

        $project_detail->update();

        $this->storeTranslations($request, $project_detail);

        return redirect()->route('project.view')->with('success', __('admin.flash.updated', ['item' => __('admin.menu.project')]));
    }

    public function delete()
    {

        $project_detail = Project::getProjectById(Auth::id(),request()->id);
        $project_detail->delete();

        return redirect()->route('project.view')->with('success', __('admin.flash.deleted', ['item' => __('admin.menu.project')]));

    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $project_detail = Project::getProjectByUserid(Auth::user()->id);

        return view(self::viewPath . 'index', compact('breadcrumbs','project_detail'));
    }
}
