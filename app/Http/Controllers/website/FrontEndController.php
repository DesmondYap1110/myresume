<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontEndController extends Controller
{
    const viewPath  = "website.template1.";

    public function index()
    {
        return view(self::viewPath . 'index');
    }

}
