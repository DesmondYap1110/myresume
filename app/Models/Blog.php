<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    const status_active = 1;
    const status_block  = 0;

    protected $table = 'blog';
    protected $guarded = [];

    /** Gallery images, cover first. */
    public function images()
    {
        return $this->hasMany(BlogImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Image as a URL for the current host. New uploads are stored as a path
     * under public/ ("uploads/abc.jpg"); older rows hold a full URL.
     */
    public function getImageAttribute($value)
    {
        if (blank($value) || preg_match('#^(https?:)?//#i', $value)) {
            return $value;
        }

        return asset(ltrim($value, '/'));
    }

    /**
     * Keeps blog.image pointing at the first gallery image (the cover).
     */
    public function syncCover(): void
    {
        $first = $this->images()->first();

        $this->image = $first ? $first->path : '';
        $this->save();
    }

    static function getBlogByUserid($id)
    {
        $query = self::with('images')->where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('id', 'desc')->get();
    }

    static function getBlogById($user_id,$id)
    {
        $query = self::with('images')->where('user_id', $user_id)->where('id', $id)->where('status', self::status_active);
        return $query->first();
    }



}
