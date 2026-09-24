<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Models\Inbox;
use App\Models\Visit_Log;
use App\Support\IpLocation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    const page ="Dashboard";
    const viewPath = "admin.template1.dashboard.";

    /** Visitors shown at a time, before "Load more". */
    const visitorPage = 20;

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
        $visit_log = Visit_Log::get_today_visit_log(Auth::user()->id);
        $all_visit_log = Visit_Log::get_visit_log(Auth::user()->id);

        $period =  collect(range(0, 6))->map(function ($i) {
            return Carbon::now()->subDays($i)->format('Y-m-d');
        })->reverse()->values()->toArray();

        $daily = Visit_Log::get_daily_visitor_counts(Auth::user()->id, $period[0]." 00:00:00", end($period)." 23:59:59");

        $data_visit = collect($period)->mapWithKeys(function ($date) use ($daily) {
            return [$date => (int) ($daily[$date] ?? 0)];
        })->toArray();

        // Today's arrivals, first page only; the rest load on demand.
        $recent_visits = Visit_Log::todayFor(Auth::user()->id)
            ->limit(self::visitorPage)
            ->get();

        IpLocation::fill($recent_visits);

        $recent_total = Visit_Log::todayFor(Auth::user()->id)->count();

        return view(self::viewPath . 'index', compact('breadcrumbs','inbox','visit_log','all_visit_log','period','data_visit','recent_visits','recent_total'));
    }
}
