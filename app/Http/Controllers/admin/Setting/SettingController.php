<?php

namespace App\Http\Controllers\admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private function setbreadcrumbs()
    {
        return [
            "CurrentPage" => "Account Setting",
            "isDashboard" => true,
            "CurrentUrl"  => route("setting.view"),
            "homeUrl" => route("dashboard.view"),
        ];
    }

    public function index()
    {
        //Set Breadcrumbs
        $breadcrumbs = $this->setbreadcrumbs();

        return view('admin.template1.setting.index',compact('breadcrumbs'));
    }
}
