<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const status_active = 1;
    const status_block  = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','slug','email','password','dob','phone','role','address','linkedIn_url','about'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Administers the site itself. Note "role" is the person's job title, so
     * the flag has its own column.
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }


    /**
     * Profile image as a URL for the current host. New uploads are stored as
     * a path under public/ ("uploads/abc.jpg"); older rows hold a full URL,
     * which is returned unchanged.
     */
    public function getImageAttribute($value)
    {
        if (blank($value) || preg_match('#^(https?:)?//#i', $value)) {
            return $value;
        }

        return asset(ltrim($value, '/'));
    }

    /**
     * Slugs that would clash with a real route or folder.
     */
    const reserved_slugs = [
        'admin', 'post', 'sitemap', 'sitemap.xml', 'robots.txt', 'favicon.ico',
        'login', 'logout', 'enquiry', 'storage', 'assets', 'uploads', 'api', 'build', 'vendor',
        'resume',
    ];

    /**
     * What goes in the website address: the slug, or the old base64 id when
     * a user has no slug yet.
     */
    public function routeKey(): string
    {
        return $this->slug ?: base64_encode((string) $this->id);
    }

    /**
     * Finds the owner of a public page from either form of the address.
     */
    static function findByRouteKey(?string $key): ?self
    {
        $key = trim((string) $key);

        if ($key === '') {
            return null;
        }

        $user = self::where('slug', $key)->where('status', self::status_active)->first();

        if ($user) {
            return $user;
        }

        // Older links use the base64 id.
        $id = base64_decode($key, true);

        return ($id !== false && ctype_digit(trim($id))) ? self::getUserByUserid(trim($id)) : null;
    }

    private ?bool $resumeReady = null;

    /**
     * True when there is enough to build a resume from: a name plus some
     * experience, education or an about text. Checked once per request.
     */
    public function hasResume(): bool
    {
        return $this->resumeReady ??= filled($this->name) && (
            filled(strip_tags((string) $this->about))
            || Experience::where('user_id', $this->id)->where('status', Experience::status_active)->exists()
            || Education::where('user_id', $this->id)->where('status', Education::status_active)->exists()
        );
    }

    /** Public download link, e.g. /resume/desmond-yap */
    public function resumeUrl(): string
    {
        return route('front.resume', $this->routeKey());
    }

    /** What the visitor's download is called, e.g. Desmond-Yap-Resume.pdf */
    public function resumeDownloadName(): string
    {
        $name = trim(preg_replace('/[^A-Za-z0-9]+/', '-', (string) $this->name), '-') ?: 'Resume';

        return $name.'-Resume.pdf';
    }

    /**
     * The chosen public template, falling back to the default when the saved
     * value is unknown or its view is missing.
     */
    public function websiteTemplate(): string
    {
        $key = (string) $this->website_template;
        $templates = (array) config('website_templates.templates', []);

        if (isset($templates[$key]) && view()->exists("website.{$key}.index")) {
            return $key;
        }

        return (string) config('website_templates.default', 'template1');
    }

    static function getUserByEmail($email)
    {
        $query = self::Where('email', $email)->where('status', self::status_active);
        return $query->limit(1)->first();
    }

    static function getUserByUserid($id)
    {
        $query = self::Where('id', $id)->where('status', self::status_active);
         return $query->orderBy('id', 'desc')->first();
    }
}
