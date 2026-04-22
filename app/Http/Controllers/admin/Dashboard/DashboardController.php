<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Models\Inbox;
use App\Models\Visit_log;
use Illuminate\Support\Facades\Auth;

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

        $inbox = Inbox::getInboxByUseridStatus(Auth::user()->id);
        $visit_log = Visit_log::get_today_visit_log(Auth::user()->id);

        return view(self::viewPath . 'index', compact('breadcrumbs','inbox','visit_log'));
    }
}
