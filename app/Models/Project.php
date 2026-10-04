<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, HasTranslations;

    const status_active = 1;
    const status_block  = 0;

    protected $table = 'project';
    protected $guarded = [];

    static function getProjectByUserid($id)
    {
        $query = self::Where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('start_date', 'desc')->get();
    }


    static function getProjectById($user_id,$id)
    {
        $query = self::Where('user_id', $user_id)->where('id', $id)->where('status', self::status_active);
        return $query->first();
    }



}
