<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    const viewPath  = "admin.template1.login.";
    public function index()
    {
        return view(self::viewPath.'index');
    }
}
