<?php

namespace App\Http\Controllers\admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private function setbreadcrumbs()
    {
        return [
            "CurrentPage" => "Blog",
            "isDashboard" => true,
            "CurrentUrl"  => route("blog.view"),
            "homeUrl" => route("dashboard.view"),
        ];
    }

    public function index()
    {
        //Set Breadcrumbs
        $breadcrumbs = $this->setbreadcrumbs();

        return view('admin.template1.blog.index',compact('breadcrumbs'));
    }
}
