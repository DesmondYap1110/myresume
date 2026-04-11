<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    const status_active = 1;
    const status_block  = 0;

    protected $table = 'experience';
    protected $guarded = [];

    static function getExperienceByUserid($id)
    {
        $query = self::Where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('id', 'desc')->get();
    }



}
