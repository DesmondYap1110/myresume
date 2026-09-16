<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    const status_active = 1;
    const status_block  = 0;

    protected $table = 'testimonial';
    protected $guarded = [];

    /**
     * Photo as a URL for the current host; full URLs pass through.
     */
    public function getImageAttribute($value)
    {
        if (blank($value) || preg_match('#^(https?:)?//#i', $value)) {
            return $value;
        }

        return asset(ltrim($value, '/'));
    }

    /** Initials shown when there is no photo. */
    public function initials(): string
    {
        return collect(preg_split('/\s+/', trim((string) $this->name)))
            ->filter()->take(2)
            ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('');
    }

    static function getTestimonialByUserid($id)
    {
        $query = self::where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('sort_order')->orderBy('id')->get();
    }

    static function getTestimonialById($user_id, $id)
    {
        $query = self::where('user_id', $user_id)->where('id', $id)->where('status', self::status_active);
        return $query->first();
    }
}
