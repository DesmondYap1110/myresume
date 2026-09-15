<?php

namespace App\Http\Controllers\admin\Blog;

use App\Http\Controllers\Controller;
use App\Support\SafeImageUpload;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    const page ="Blog";
    const viewPath = "admin.template1.blog.";

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
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

        $blog = new Blog();
        $blog->user_id      = Auth::id();
        $blog->title        = $request->title;
        $blog->description  = $request->description;

        if ($request->hasFile('image')) {
            $blog->image = SafeImageUpload::store($request->file('image'), 'uploads');
        }

        $blog->save();

        return redirect()->route('blog.view')->with('success', 'Add Blog successful!');
    }

    public function update(Request $request)
    {
        if(isset($request->existing_pond_file))
        {
            $request->validate([
                'title'       => 'required',
                'description' => 'required'
            ]);
        }
        else
        {
            $request->validate([
                'title'       => 'required',
                'description' => 'required',
                'image'       => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
            ]);
        }

        $blog =  Blog::getBlogById(Auth::id(),request()->id);
        $blog->title        = $request->title;
        $blog->description  = $request->description;

        if(!isset($request->existing_pond_file))
        {
            if ($request->hasFile('image'))
            {
                $blog->image = SafeImageUpload::store($request->file('image'), 'uploads');
            }
        }

        $blog->update();

        return redirect()->route('blog.view')->with('success', 'Edit Blog successful!');

    }

    public function edit()
    {
        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit',request()->id))->get();

        $blog = Blog::getBlogById(Auth::id(),request()->id);

        return view(self::viewPath . 'edit', compact('breadcrumbs','blog'));
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $blog = Blog::getBlogByUserid(Auth::user()->id);

        return view(self::viewPath . 'index', compact('breadcrumbs','blog'));
    }
}
