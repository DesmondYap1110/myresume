<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    const status_active = 1;
    const status_block  = 0;

    const read_status_active = 1;
    const read_status_inactive = 0;

    protected $table = 'inbox';
    protected $guarded = [];

    static function getInboxByUserid($id)
    {
        $query = self::Where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('id', 'desc')->get();
    }

    /**
     * One owner's messages, narrowed by date and read state.
     *
     * A plain range rather than whereDate(), so an index on created_at stays
     * usable as the table grows.
     */
    public static function filtered($user_id, $from = null, $to = null, string $read = 'any')
    {
        return self::query()
            ->where('user_id', $user_id)
            ->where('status', self::status_active)
            ->when($from, fn ($q) => $q->where('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->where('created_at', '<=', $to))
            ->when($read === 'read', fn ($q) => $q->where('read_status', self::read_status_active))
            ->when($read === 'unread', fn ($q) => $q->where('read_status', self::read_status_inactive))
            ->orderByDesc('id');
    }

    static function getInboxByUseridStatus($id,$read_status = self::read_status_inactive, $limit = null)
    {
        $query = self::Where('user_id', $id)
        ->where('status', self::status_active)
        ->where("read_status",$read_status)
        ->orderBy('id', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Just the number, for the badge that gets polled every few seconds -
     * no point hydrating full rows for a count.
     */
    static function countUnreadByUserid($id, $read_status = self::read_status_inactive)
    {
        return self::where('user_id', $id)
            ->where('status', self::status_active)
            ->where('read_status', $read_status)
            ->count();
    }

    static function getInboxtById($user_id,$id)
    {
        $query = self::Where('user_id', $user_id)->where('id', $id)->where('status', self::status_active);
        return $query->first();
    }



}
