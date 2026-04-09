<?php

namespace App\Http\Controllers\admin\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    private function setbreadcrumbs()
    {
        return [
            "CurrentPage" => "Education",
            "isDashboard" => true,
            "CurrentUrl"  => route("education.view"),
            "homeUrl" => route("dashboard.view"),
        ];
    }

    public function index()
    {
        //Set Breadcrumbs
        $breadcrumbs = $this->setbreadcrumbs();

        return view('admin.template1.education.index',compact('breadcrumbs'));
    }
}
