<?php

namespace App\Http\Controllers\admin\Experience;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    private function setbreadcrumbs()
    {
        return [
            "CurrentPage" => "Experience",
            "isDashboard" => true,
            "CurrentUrl"  => route("experience.view"),
            "homeUrl" => route("dashboard.view"),
        ];
    }

    public function index()
    {
        //Set Breadcrumbs
        $breadcrumbs = $this->setbreadcrumbs();

        return view('admin.template1.experience.index',compact('breadcrumbs'));
    }
}
