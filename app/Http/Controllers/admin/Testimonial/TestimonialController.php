<?php

namespace App\Http\Controllers\admin\Testimonial;

use App\Helpers\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\SavesTranslations;
use App\Models\Testimonial;
use App\Support\SafeImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    use SavesTranslations;
    const page = "Testimonial";
    const viewPath = "admin.template1.testimonial.";

    /** Where testimonial photos are stored, under public/. */
    const uploadDir = 'uploads/testimonials';

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    private function rules(): array
    {
        return [
            'name'       => 'required|max:255',
            'position'   => 'nullable|max:255',
            'message'    => 'required|max:1000',
            'rating'     => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $testimonial = Testimonial::getTestimonialByUserid(Auth::id());

        return view(self::viewPath.'index', compact('breadcrumbs', 'testimonial'));
    }

    public function add()
    {
        $breadcrumbs = $this->breadcrumbs->add('Add '.self::page, route($this->route.'add'))->get();

        return view(self::viewPath.'add', compact('breadcrumbs'));
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->rules());

        $testimonial = new Testimonial();
        $testimonial->user_id    = Auth::id();
        $testimonial->name       = $data['name'];
        $testimonial->position   = $data['position'] ?? null;
        $testimonial->message    = $data['message'];
        $testimonial->rating     = $data['rating'];
        $testimonial->sort_order = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $testimonial->image = SafeImageUpload::store($request->file('image'), self::uploadDir);
        }

        $testimonial->save();

        $this->storeTranslations($request, $testimonial);

        return redirect()->route($this->route.'view')->with('success', __('admin.flash.added', ['item' => __('admin.menu.testimonial')]));
    }

    public function edit()
    {
        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit', request()->id))->get();

        $testimonial_detail = Testimonial::getTestimonialById(Auth::id(), request()->id);
        if (!$testimonial_detail) abort(404);

        return view(self::viewPath.'edit', compact('breadcrumbs', 'testimonial_detail'));
    }

    public function update(Request $request)
    {
        $testimonial = Testimonial::getTestimonialById(Auth::id(), request()->id);
        if (!$testimonial) abort(404);

        $data = $request->validate($this->rules());
        $old = $testimonial->getRawOriginal('image');

        $testimonial->name       = $data['name'];
        $testimonial->position   = $data['position'] ?? null;
        $testimonial->message    = $data['message'];
        $testimonial->rating     = $data['rating'];
        $testimonial->sort_order = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $testimonial->image = SafeImageUpload::store($request->file('image'), self::uploadDir);
        } elseif ($request->boolean('remove_image')) {
            $testimonial->image = null;
        }

        $testimonial->update();

        $this->storeTranslations($request, $testimonial);

        // Drop the old file once the row is saved.
        if ($old && $testimonial->getRawOriginal('image') !== $old) {
            SafeImageUpload::delete($old, self::uploadDir);
        }

        return redirect()->route($this->route.'view')->with('success', __('admin.flash.updated', ['item' => __('admin.menu.testimonial')]));
    }

    public function delete()
    {
        $testimonial = Testimonial::getTestimonialById(Auth::id(), request()->id);
        if (!$testimonial) abort(404);

        $image = $testimonial->getRawOriginal('image');
        $testimonial->delete();

        if ($image) {
            SafeImageUpload::delete($image, self::uploadDir);
        }

        return redirect()->route($this->route.'view')->with('success', __('admin.flash.deleted', ['item' => __('admin.menu.testimonial')]));
    }
}
