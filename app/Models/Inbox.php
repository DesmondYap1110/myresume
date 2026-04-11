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

    static function getInboxByUseridStatus($id)
    {
        $query = self::Where('user_id', $id)
        ->where('status', self::status_active)
        ->where("read_status",self::read_status_inactive);

        return $query->orderBy('id', 'desc')->get();
    }



}
