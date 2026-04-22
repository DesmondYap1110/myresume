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
