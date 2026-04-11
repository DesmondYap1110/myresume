<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    const status_active = 1;
    const status_block  = 0;

    protected $table = 'education';
    protected $guarded = [];

    static function getEducationByUserid($id)
    {
        $query = self::Where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('year', 'desc')->get();
    }

    static function getEducationById($user_id,$id)
    {
        $query = self::Where('user_id', $user_id)->where('id', $id)->where('status', self::status_active);
        return $query->first();
    }




}
