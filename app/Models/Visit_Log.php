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

    static function get_today_visit_log($user_id)
    {
        $query = self::where('user_id', $user_id)
            ->whereBetween('created_at', [
                Carbon::today()->startOfDay(),
                Carbon::today()->endOfDay()
            ])
            ->select(
                'ip_address',
                DB::raw('MIN(created_at) as start_date'),
                DB::raw('MAX(created_at) as end_date')
            )
            ->groupBy('ip_address')
            ->get();

        return $query;
    }
}
