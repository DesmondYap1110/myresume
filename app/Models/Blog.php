<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, HasTranslations;

    const status_active = 1;
    const status_block  = 0;

    protected $table = 'blog';

    // Written through setMedia(), never straight from a form.
    protected $guarded = ['media'];

    /**
     * Embedded links, already parsed. Old rows have none, so this is always
     * a list - never null - for the views to walk.
     */
    public function getMediaAttribute($value): array
    {
        $media = is_string($value) ? json_decode($value, true) : $value;

        return is_array($media) ? array_values(array_filter($media, 'is_array')) : [];
    }

    /** Replace the post's links, parsing each one on the way in. */
    public function setMedia($urls): void
    {
        $media = \App\Support\MediaEmbed::parseMany($urls);

        $this->attributes['media'] = $media ? json_encode($media, JSON_UNESCAPED_SLASHES) : null;
    }

    /** The links as typed, for putting back in the edit form. */
    public function mediaUrls(): array
    {
        return array_column($this->media, 'url');
    }

    /** Gallery images, cover first. */
    public function images()
    {
        return $this->hasMany(BlogImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * The pictures to show in one language.
     *
     * A language with its own set gets that set; otherwise the ones marked
     * for every language (locale NULL) are used, so a post translated into
     * Chinese without new screenshots still shows the English ones.
     */
    public function imagesFor(?string $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $all = $this->images;

        $own = $all->where('locale', $locale)->values();

        return $own->isNotEmpty() ? $own : $all->whereNull('locale')->values();
    }

    /** The pictures a language has of its own, for the admin form. */
    public function imagesOf(?string $locale)
    {
        return $this->images
            ->filter(fn ($image) => $locale === null ? $image->locale === null : $image->locale === $locale)
            ->values();
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

    /*
     * The two above are what the public site asks for, so they only return
     * posts that are switched on. The back office needs the hidden ones too -
     * otherwise turning a post off would take it out of your own list and
     * leave no way to turn it back on.
     */

    static function getAllByUserid($id)
    {
        return self::with('images')->where('user_id', $id)->orderBy('id', 'desc')->get();
    }

    static function getAnyById($user_id, $id)
    {
        return self::with('images')->where('user_id', $user_id)->where('id', $id)->first();
    }



}
