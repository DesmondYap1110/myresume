<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
    protected $table = 'blog_image';

    protected $fillable = ['blog_id', 'locale', 'path', 'sort_order'];

    protected $appends = ['url', 'is_video'];

    protected $hidden = ['blog_id', 'created_at', 'updated_at'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * The image as a URL for the current host; full URLs pass through.
     */
    public function getUrlAttribute(): string
    {
        $path = (string) $this->path;

        if ($path === '' || preg_match('#^(https?:)?//#i', $path)) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    /** A video is shown with <video>, a picture with <img>. */
    public function getIsVideoAttribute(): bool
    {
        return \App\Support\SafeMediaUpload::isVideo($this->path);
    }

    /** Whether the file was uploaded here (and so is ours to delete). */
    public function isLocalUpload(): bool
    {
        return str_starts_with((string) $this->path, 'uploads/');
    }
}
