<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory, HasTranslations;

    const status_active = 1;
    const status_block  = 0;

    const work_status_active   = 1;
    const work_status_inactive = 0;


    protected $table = 'experience';
    protected $guarded = [];

    static function getExperienceByUserid($id)
    {
        $query = self::Where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('start_date', 'desc')->get();
    }

    static function getExperienceById($user_id,$id)
    {
        $query = self::Where('user_id', $user_id)->where('id', $id)->where('status', self::status_active);
        return $query->first();
    }


}
