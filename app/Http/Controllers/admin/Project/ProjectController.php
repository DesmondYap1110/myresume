<?php

namespace App\Http\Controllers\admin\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private function setbreadcrumbs()
    {
        return [
            "CurrentPage" => "Project",
            "isDashboard" => true,
            "CurrentUrl"  => route("project.view"),
            "homeUrl" => route("dashboard.view"),
        ];
    }

    public function index()
    {
        //Set Breadcrumbs
        $breadcrumbs = $this->setbreadcrumbs();

        return view('admin.template1.project.index',compact('breadcrumbs'));
    }
}
