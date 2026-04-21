<?php

namespace App\Http\Controllers\admin\Education;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Education;
class EducationController extends Controller
{
    const page ="Education";
    const viewPath = "admin.template1.education.";

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

    public function create(Request $request)
    {
        $education = new Education();
        $education->user_id     = Auth::id();
        $education->institution = $request->institution;
        $education->certificate = $request->certificate;
        $education->achievement = $request->achievement;
        $education->year        = $request->year;
        $education->save();

       return redirect()->route('education.view')->with('success', 'Add Education successful!');
    }

    public function edit(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit',request()->id))->get();
        $education_detail              = Education::getEducationById(Auth::id(),request()->id);
        if(!$education_detail) abort(404);

        return view(self::viewPath . 'edit', compact('breadcrumbs','education_detail'));
    }

    public function update(Request $request)
    {
        $education_detail              = Education::getEducationById(Auth::id(),request()->id);
        $education_detail->institution = $request->institution;
        $education_detail->certificate = $request->certificate;
        $education_detail->achievement = $request->achievement;
        $education_detail->year        = $request->year;

        $education_detail->update();

        return redirect()->route('education.view')->with('success', 'Edit Education successful!');
    }

    public function delete()
    {

        $education_detail = Education::getEducationById(Auth::id(),request()->id);
        $education_detail->delete();

        return redirect()->route('education.view')->with('success', 'Delete Education successful!');

    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $education_detail = Education::getEducationByUserid(Auth::user()->id);

        return view(self::viewPath . 'index', compact('breadcrumbs','education_detail'));
    }
}
