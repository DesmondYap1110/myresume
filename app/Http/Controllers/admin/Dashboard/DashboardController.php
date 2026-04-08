<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function setbreadcrumbs()
    {
        return [
            "CurrentPage" => "Profile",
            "isDashboard" => false
        ];
    }

    public function index()
    {
        $breadcrumbs = $this->setbreadcrumbs();
        return view('admin.template1.dashboard.index',compact('breadcrumbs'));
    }

}
