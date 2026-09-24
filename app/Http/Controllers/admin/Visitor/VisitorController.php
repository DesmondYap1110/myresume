<?php

namespace App\Http\Controllers\admin\Visitor;

use App\Helpers\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Models\Visit_Log;
use App\Support\IpLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Admin > Visitor: every visit to this owner's public website - the address
 * it came from, where that address is, the page and when.
 *
 * Locations are resolved for the page being looked at and written back, so
 * the list fills itself in as it is browsed and never asks twice.
 */
class VisitorController extends Controller
{
    const page = "Visitor";
    const viewPath = "admin.template1.visitor.";
    const perPage = 25;

    /** Rows per "Load more" on the dashboard. */
    const perLoad = 20;

    /** The Period box. "custom" hands over to the two date fields. */
    const periods = [
        'all' => 'All time',
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'last7' => 'Last 7 days',
        'last30' => 'Last 30 days',
        'month' => 'This month',
        'year' => 'This year',
        'custom' => 'Custom range',
    ];

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function index(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs->get();

        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ], [
            'from.date' => 'The "from" date is not a date.',
            'to.date' => 'The "to" date is not a date.',
        ]);

        // A period that is not one of ours falls back to everything rather
        // than erroring: it only ever arrives from a stale link.
        $period = (string) $request->query('period', 'all');
        $period = array_key_exists($period, self::periods) ? $period : 'all';

        [$from, $to] = $this->range($period, $request);

        $visits = $this->filtered($from, $to)
            ->orderByDesc('created_at')
            ->paginate(self::perPage)
            ->withQueryString();

        IpLocation::fill(collect($visits->items()));

        $totals = [
            'visits' => $this->filtered($from, $to)->count(),
            'visitors' => $this->filtered($from, $to)->distinct('ip_address')->count('ip_address'),
            'today' => $this->filtered(today()->startOfDay(), today()->endOfDay())->count(),
        ];

        $filter = [
            'period' => $period,
            'periods' => self::periods,
            'from' => $from?->format('Y-m-d'),
            'to' => $to?->format('Y-m-d'),
            'on' => (bool) ($from || $to),
            'label' => $this->rangeLabel($from, $to),
        ];

        return view(self::viewPath.'index', compact('breadcrumbs', 'visits', 'totals', 'filter'));
    }

    /**
     * The dates the chosen period covers, widened to whole days.
     *
     * Whole days rather than whereDate() so the (user_id, created_at) index
     * still applies. "Custom" reads the two date boxes, swapped round if they
     * were given backwards.
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

    /** "01 Jan 2026 - 31 Dec 2026", or an open end, or everything. */
    private function rangeLabel(?Carbon $from, ?Carbon $to): string
    {
        if (!$from && !$to) {
            return 'All time';
        }

        if ($from && $to) {
            return $from->format('d M Y').' – '.$to->format('d M Y');
        }

        return $from
            ? 'From '.$from->format('d M Y')
            : 'Up to '.$to->format('d M Y');
    }

    /** This owner's visits, within whichever end of the range was given. */
    private function filtered(?Carbon $from, ?Carbon $to)
    {
        return Visit_Log::where('user_id', (string) Auth::id())
            ->when($from, fn ($q) => $q->where('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->where('created_at', '<=', $to));
    }

    /**
     * The next slice of today's visitors, for the dashboard's "Load more".
     *
     * Returns data rather than markup: the browser builds the rows with
     * textContent, so a user agent string can never be read as HTML.
     */
    public function today(Request $request)
    {
        $offset = max(0, (int) $request->query('offset', 0));
        $limit = self::perLoad;

        // One extra row answers "is there more?" without a second COUNT.
        $rows = Visit_Log::uniqueTodayFor(Auth::id())
            ->offset($offset)
            ->limit($limit + 1)
            ->get();

        $more = $rows->count() > $limit;
        $rows = $rows->take($limit);

        IpLocation::fill($rows);

        $summary = Visit_Log::summaryPerDayFor(Auth::id(), today()->startOfDay(), today()->endOfDay());

        return response()->json([
            'more' => $more,
            'next' => $offset + $rows->count(),
            'rows' => $rows->map(function ($v) use ($summary) {
                $seen = $summary[$v->ip_address.'|'.$v->created_at?->format('Y-m-d')] ?? null;
                $hits = $seen['hits'] ?? 1;

                return [
                    'ip' => $v->ip_address ?: '—',
                    'where' => IpLocation::label($v->country, $v->city),
                    'hits' => $hits,
                    'at' => $hits > 1
                        ? $seen['first']->format('g:ia').' – '.$seen['last']->format('g:ia')
                        : $v->created_at?->format('g:ia'),
                    'ago' => $v->created_at?->diffForHumans(),
                ];
            })->values(),
        ]);
    }
}
