<?php

namespace App\Http\Controllers\admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\SavesTranslations;
use App\Support\SafeMediaUpload;
use App\Support\SafeVideoUpload;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{
    use SavesTranslations;
    const page ="Blog";
    const viewPath = "admin.template1.blog.";

    /** Most images one post may have. */
    const maxImages = 10;

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function add()
    {
        $breadcrumbs = $this->breadcrumbs->add('Add '.self::page, route($this->route.'add'))->get();
        return view(self::viewPath . 'add', compact('breadcrumbs'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'images'      => 'required|array|min:1|max:'.self::maxImages,
            'images.*'    => 'file|mimes:jpg,jpeg,png,gif,webp,mp4,webm|max:20480',
            'media'       => 'array|max:'.\App\Support\MediaEmbed::max,
            'media.*'     => 'nullable|string|max:500',
            'status'      => 'nullable|boolean',
        ] + $this->localeImageRules(), [
            'images.required' => 'Please add at least one image.',
            'images.max'      => 'A blog can have at most '.self::maxImages.' images.',
            'images.*.max'    => 'Each file must be 20 MB or smaller.',
            'images.*.mimes'  => 'Use a JPG, PNG, GIF, WebP, MP4 or WebM file.',
        ]);

        $stored = [];

        try {
            DB::transaction(function () use ($request, &$stored) {
                $blog = new Blog();
                $blog->user_id     = Auth::id();
                $blog->title       = $request->title;
                $blog->description = $request->description;
                $blog->image       = '';
                // An unticked switch posts nothing at all, so absent means off.
                $blog->status      = $request->boolean('status') ? Blog::status_active : Blog::status_block;
                $blog->setMedia($request->input('media', []));
                $blog->save();

                foreach ($request->file('images') as $i => $file) {
                    $path = SafeMediaUpload::store($file, 'uploads', "images.$i");
                    $stored[] = $path;
                    $blog->images()->create(['path' => $path, 'sort_order' => $i]);
                }

                // Pictures for the other languages, when a language needs its
                // own - screenshots of a Chinese screen, say.
                $this->storeLocaleImages($request, $blog, $stored);

                $blog->syncCover();
            });
        } catch (\Throwable $e) {
            // Nothing was saved, so drop any files already written.
            foreach ($stored as $path) {
                SafeMediaUpload::delete($path, 'uploads');
            }
            throw $e;
        }

        return redirect()->route('blog.view')->with('success', __('admin.flash.added', ['item' => __('admin.menu.blog')]));
    }

    public function update(Request $request)
    {
        $blog = Blog::getAnyById(Auth::id(), request()->id);
        if (!$blog) abort(404);

        $request->validate([
            'title'           => 'required|max:255',
            'description'     => 'required',
            'image_order'     => 'array',
            'image_order.*'   => 'integer',
            'remove_images'   => 'array',
            'remove_images.*' => 'integer',
            'images'          => 'array|max:'.self::maxImages,
            'images.*'        => 'file|mimes:jpg,jpeg,png,gif,webp,mp4,webm|max:20480',
            'media'           => 'array|max:'.\App\Support\MediaEmbed::max,
            'media.*'         => 'nullable|string|max:500',
            'status'          => 'nullable|boolean',
        ] + $this->localeImageRules(), [
            'images.*.max' => 'Each file must be 20 MB or smaller.',
            'images.*.mimes' => 'Use a JPG, PNG, GIF, WebP, MP4 or WebM file.',
        ]);

        // Only this post's own images can be kept, reordered or removed.
        $existing = $blog->images->keyBy('id');
        $remove = collect($request->input('remove_images', []))->map(fn ($id) => (int) $id)->filter(fn ($id) => $existing->has($id));
        $kept = $existing->count() - $remove->count();
        $new = count($request->file('images', []));

        if ($kept + $new < 1) {
            throw ValidationException::withMessages(['images' => 'A blog needs at least one image.']);
        }
        if ($kept + $new > self::maxImages) {
            throw ValidationException::withMessages(['images' => 'A blog can have at most '.self::maxImages.' images.']);
        }

        $stored = [];
        $toDelete = [];

        try {
            DB::transaction(function () use ($request, $blog, $existing, $remove, &$stored, &$toDelete) {
                $blog->title       = $request->title;
                $blog->description = $request->description;
                $blog->status      = $request->boolean('status') ? Blog::status_active : Blog::status_block;
                $blog->setMedia($request->input('media', []));

                foreach ($remove as $id) {
                    $image = $existing->get($id);
                    if ($image->isLocalUpload()) $toDelete[] = $image->path;
                    $image->delete();
                }

                // Kept images in the order shown on the form, then any not listed.
                $order = collect($request->input('image_order', []))->map(fn ($id) => (int) $id)
                    ->filter(fn ($id) => $existing->has($id) && !$remove->contains($id))
                    ->unique()->values();
                $order = $order->merge($existing->keys()->diff($order)->diff($remove))->values();

                $position = 0;
                foreach ($order as $id) {
                    $existing->get($id)->update(['sort_order' => $position++]);
                }

                foreach ($request->file('images', []) as $i => $file) {
                    $path = SafeMediaUpload::store($file, 'uploads', "images.$i");
                    $stored[] = $path;
                    $blog->images()->create(['path' => $path, 'sort_order' => $position++]);
                }

                $this->storeLocaleImages($request, $blog, $stored);

                $blog->syncCover();
            });
        } catch (\Throwable $e) {
            foreach ($stored as $path) {
                SafeMediaUpload::delete($path, 'uploads');
            }
            throw $e;
        }

        // Files are removed only once the database change has committed.
        foreach ($toDelete as $path) {
            SafeMediaUpload::delete($path, 'uploads');
        }

        $this->storeTranslations($request, $blog);

        return redirect()->route('blog.view')->with('success', __('admin.flash.updated', ['item' => __('admin.menu.blog')]));
    }

    /**
     * Pictures a language has of its own, posted as images_<locale>[].
     *
     * Only the languages we publish are accepted, and never the default one:
     * those are the ordinary images above, shown wherever a language has no
     * set of its own.
     */
    private function storeLocaleImages(Request $request, Blog $blog, array &$stored): void
    {
        $default = (string) config('locales.default');

        foreach (array_keys((array) config('locales.supported', [])) as $locale) {
            if ($locale === $default) {
                continue;
            }

            $files = $request->file('images_'.$locale, []);

            foreach (array_slice($files, 0, self::maxImages) as $i => $file) {
                $path = SafeMediaUpload::store($file, 'uploads', 'images_'.$locale.'.'.$i);
                $stored[] = $path;

                $blog->images()->create([
                    'locale' => $locale,
                    'path' => $path,
                    'sort_order' => $i,
                ]);
            }
        }
    }

    /** The rules for those extra uploads, merged into the module's own. */
    private function localeImageRules(): array
    {
        $rules = [];
        $default = (string) config('locales.default');

        foreach (array_keys((array) config('locales.supported', [])) as $locale) {
            if ($locale === $default) {
                continue;
            }

            $rules['images_'.$locale] = 'array|max:'.self::maxImages;
            $rules['images_'.$locale.'.*'] = 'file|mimes:jpg,jpeg,png,gif,webp,mp4,webm|max:20480';
        }

        return $rules;
    }

    public function delete()
    {
        $blog = Blog::getAnyById(Auth::id(), request()->id);
        if (!$blog) abort(404);

        $files = $blog->images->filter(fn (BlogImage $image) => $image->isLocalUpload())->pluck('path');

        $blog->delete(); // blog_image rows go with it (cascade)

        foreach ($files as $path) {
            SafeMediaUpload::delete($path, 'uploads');
        }

        return redirect()->route('blog.view')->with('success', __('admin.flash.deleted', ['item' => __('admin.menu.blog')]));
    }

    public function edit()
    {
        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit',request()->id))->get();

        $blog = Blog::getAnyById(Auth::id(), request()->id);
        if (!$blog) abort(404);

        return view(self::viewPath . 'edit', compact('breadcrumbs','blog'));
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $blog = Blog::getAllByUserid(Auth::user()->id);

        return view(self::viewPath . 'index', compact('breadcrumbs','blog'));
    }
}
