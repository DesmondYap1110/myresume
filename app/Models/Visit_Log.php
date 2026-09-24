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
