<?php

namespace App\Http\Controllers\admin\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.template1.profile.index');
    }
}
