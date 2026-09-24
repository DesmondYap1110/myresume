<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Visit_Log extends Model
{
    use HasFactory;


    protected $table = 'visit_log';
    protected $guarded = [];

    static function set_visit_log($user_id)
    {
        Visit_Log::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'user_id' => $user_id,
        ]);
    }

    /**
     * Today's visits for one owner, newest first.
     *
     * Two things keep the (user_id, created_at) index in play: a plain range
     * rather than whereDate(), because a function around the column rules the
     * index out; and a string user_id, because the column is a varchar and
     * comparing it to an integer makes MySQL scan the table instead.
     */
    public static function todayFor($user_id)
    {
        return self::query()
            ->where('user_id', (string) $user_id)
            ->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
            ->orderByDesc('created_at');
    }

    /**
     * One row per address per day - the last visit that address made on that
     * day. Somebody who reloads the page ten times is one line, not ten.
     *
     * MAX(id) rather than MAX(created_at): ids are sequential, so it names an
     * exact row, which keeps the page and the time shown genuinely that
     * visit's rather than values picked from different rows.
     */
    public static function uniquePerDayFor($user_id, $from = null, $to = null)
    {
        return self::query()
            ->whereIn('id', function ($q) use ($user_id, $from, $to) {
                $q->from('visit_log')
                    ->selectRaw('MAX(id)')
                    ->where('user_id', (string) $user_id)
                    ->when($from, fn ($x) => $x->where('created_at', '>=', $from))
                    ->when($to, fn ($x) => $x->where('created_at', '<=', $to))
                    ->groupBy('ip_address', DB::raw('DATE(created_at)'));
            })
            ->orderByDesc('created_at');
    }

    /** Today's addresses, one line each. */
    public static function uniqueTodayFor($user_id)
    {
        return self::uniquePerDayFor($user_id, Carbon::today()->startOfDay(), Carbon::today()->endOfDay());
    }

    /**
     * What each address did on each day: how many times it came, and the
     * first and last time it did. Keyed "ip|Y-m-d" so a grouped row can look
     * its own summary up.
     */
    public static function summaryPerDayFor($user_id, $from = null, $to = null)
    {
        return self::query()
            ->where('user_id', (string) $user_id)
            ->when($from, fn ($x) => $x->where('created_at', '>=', $from))
            ->when($to, fn ($x) => $x->where('created_at', '<=', $to))
            ->select(
                'ip_address',
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as hits'),
                DB::raw('MIN(created_at) as first_at'),
                DB::raw('MAX(created_at) as last_at')
            )
            ->groupBy('ip_address', DB::raw('DATE(created_at)'))
            ->get()
            ->mapWithKeys(fn ($r) => [$r->ip_address.'|'.$r->day => [
                'hits' => (int) $r->hits,
                'first' => Carbon::parse($r->first_at),
                'last' => Carbon::parse($r->last_at),
            ]]);
    }

    static function get_today_visit_log($user_id = null, $startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? Carbon::today()->startOfDay();
        $endDate   = $endDate ?? Carbon::today()->endOfDay();

        return self::query()
            ->when($user_id, fn ($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'ip_address',
                DB::raw('MIN(created_at) as start_date'),
                DB::raw('MAX(created_at) as end_date')
            )
            ->groupBy('ip_address')
            ->get();
    }

    /**
     * Unique visitors per day across a range, keyed by Y-m-d. One query,
     * rather than one per day on the dashboard chart.
     */
    static function get_daily_visitor_counts($user_id, $startDate, $endDate)
    {
        return self::query()
            ->when($user_id, fn ($q) => $q->where('user_id', $user_id))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as visit_date'),
                DB::raw('COUNT(DISTINCT ip_address) as visitors')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('visitors', 'visit_date');
    }

    static function get_visit_log($user_id)
    {
        $query = self::where('user_id', $user_id)
            ->select(
                'ip_address',
                DB::raw('DATE(created_at) as visit_date'),
                DB::raw('MIN(created_at) as start_date'),
                DB::raw('MAX(created_at) as end_date')
            )
            ->groupBy('ip_address', DB::raw('DATE(created_at)'))
            ->orderBy('start_date')
            ->get();

        return $query;
    }
}
