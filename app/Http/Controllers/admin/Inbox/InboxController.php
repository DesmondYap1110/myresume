<?php

namespace App\Http\Controllers\admin\Inbox;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inbox;

class InboxController extends Controller
{
    const page ="Inbox";
    const viewPath = "admin.template1.inbox.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }


    /** The Period box. "custom" hands over to the two date fields. */
    const periods = [
        'all' => 'all_time',
        'today' => 'today',
        'yesterday' => 'yesterday',
        'last7' => 'last_7_days',
        'last30' => 'last_30_days',
        'month' => 'this_month',
        'year' => 'this_year',
        'custom' => 'custom_range',
    ];

    public function index(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs->get();

        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        // An unknown period only ever arrives from a stale link, so it falls
        // back to everything rather than erroring.
        $period = (string) $request->query('period', 'all');
        $period = array_key_exists($period, self::periods) ? $period : 'all';

        $read = $request->query('read');
        $read = in_array($read, ['read', 'unread'], true) ? $read : 'any';

        [$from, $to] = $this->range($period, $request);

        $inbox = Inbox::filtered(Auth::id(), $from, $to, $read)->get();

        $filter = [
            'period' => $period,
            'periods' => self::periods,
            'read' => $read,
            'from' => $from?->format('Y-m-d'),
            'to' => $to?->format('Y-m-d'),
            'on' => (bool) ($from || $to || $read !== 'any'),
            'label' => $this->rangeLabel($from, $to),
            'unread' => Inbox::filtered(Auth::id(), $from, $to, 'unread')->count(),
        ];

        return view(self::viewPath . 'index', compact('breadcrumbs', 'inbox', 'filter'));
    }

    /**
     * The dates the chosen period covers, widened to whole days.
     *
     * Whole days rather than whereDate(), so an index on created_at can
     * still be used, and swapped round if given backwards.
     *
     * @return array{0: ?Carbon, 1: ?Carbon}
     */
    private function range(string $period, Request $request): array
    {
        $today = Carbon::today();

        [$from, $to] = match ($period) {
            'today' => [$today->copy(), $today->copy()],
            'yesterday' => [$today->copy()->subDay(), $today->copy()->subDay()],
            'last7' => [$today->copy()->subDays(6), $today->copy()],
            'last30' => [$today->copy()->subDays(29), $today->copy()],
            'month' => [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()],
            'year' => [$today->copy()->startOfYear(), $today->copy()->endOfYear()],
            'custom' => [
                $request->filled('from') ? Carbon::parse($request->query('from')) : null,
                $request->filled('to') ? Carbon::parse($request->query('to')) : null,
            ],
            default => [null, null],
        };

        if ($from && $to && $from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        return [$from?->startOfDay(), $to?->endOfDay()];
    }

    /** "01 Jan 2026 - 31 Dec 2026", an open end, or everything. */
    private function rangeLabel(?Carbon $from, ?Carbon $to): string
    {
        if (!$from && !$to) {
            return __('admin.ui.all_time');
        }

        if ($from && $to) {
            return $from->format('d M Y').' – '.$to->format('d M Y');
        }

        return $from
            ? __('admin.ui.from_date', ['date' => $from->format('d M Y')])
            : __('admin.ui.to_date', ['date' => $to->format('d M Y')]);
    }

    /**
     * Polled from the navbar so the unread badge updates without a page
     * reload. Kept deliberately small: a count query plus a handful of
     * rows, not the full inbox.
     */
    public function unread()
    {
        $userId = Auth::id();

        $items = Inbox::getInboxByUseridStatus($userId, Inbox::read_status_inactive, 8)
            ->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'subject' => \Illuminate\Support\Str::words($item->subject, 4, '...'),
                'time' => $item->created_at->diffForHumans(),
                'url' => route('inbox.view.message', $item->id),
            ]);

        return response()->json([
            'count' => Inbox::countUnreadByUserid($userId),
            'items' => $items,
        ]);
    }

    public function delete()
    {

        $inbox = Inbox::getInboxtById(Auth::id(),request()->id);
        $inbox->delete();

        return redirect()->route('inbox.view')->with('success', __('admin.flash.deleted', ['item' => __('admin.ui.message')]));

    }

    public function viewmessage()
    {
        $breadcrumbs = $this->breadcrumbs->add('View '.self::page, route($this->route.'view.message',request()->id))->get();
        $inbox = Inbox::getInboxtById(Auth::user()->id,request()->id);
        if(!$inbox) abort(404);

        if($inbox->read_status == Inbox::read_status_inactive)
        {
            $inbox = Inbox::findOrFail(request()->id);

            $inbox->read_status = Inbox::read_status_active;
            $inbox->save();
        }


        return view(self::viewPath . 'viewmessage', compact('breadcrumbs','inbox'));
    }

    public function status(Request $request)
    {

        $inbox = Inbox::findOrFail(request()->id);

        $inbox->read_status = !$inbox->read_status;
        $inbox->save();

        return redirect()->route('inbox.view')->with('success', __('admin.flash.read_status'));
    }

    public function editstatus($id)
    {

        $inbox = Inbox::findOrFail(request()->id);

        $inbox->read_status = !$inbox->read_status;
        $inbox->save();

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully'
        ]);
    }
    public function readAll()
    {
        $inbox= Inbox::getInboxByUseridStatus(Auth::user()->id);
        $inbox->each->update(['read_status'=> inbox::read_status_active]);
        return redirect()->route('inbox.view')->with('success', __('admin.flash.read_status'));
    }
}
