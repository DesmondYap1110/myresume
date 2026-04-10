<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    const page ="Dashboard";
    const viewPath = "admin.template1.dashboard.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        return view(self::viewPath . 'index', compact('breadcrumbs'));
    }
}
