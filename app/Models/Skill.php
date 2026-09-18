<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    const status_active = 1;
    const status_block  = 0;

    protected $table = 'skill';
    protected $guarded = [];

    static function getSkillByUserid($id)
    {
        $query = self::where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('sort_order')->orderBy('id')->get();
    }

    static function getSkillById($user_id, $id)
    {
        $query = self::where('user_id', $user_id)->where('id', $id)->where('status', self::status_active);
        return $query->first();
    }
}
