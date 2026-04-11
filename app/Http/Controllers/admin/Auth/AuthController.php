<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    const viewPath  = "admin.template1.login.";
    public function index()
    {
        return view(self::viewPath.'index');
    }

    private function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    }


    public function login(Request $request)
    {
        // 1. Validate input
        $this->validateLogin($request);

        // 2. Check user status + login attempt
        if (Auth::attempt(['email' => $request->email,'password' => $request->password,'status' => 1]))
        {
            // 3. Prevent session fixation attack
            $request->session()->regenerate();

            session([
                'user_id'   => Auth::user()->id,
                'user_name' => Auth::user()->name,
                'user_email'=> Auth::user()->email
            ]);

            return redirect('/admin/dashboard')->with('success', 'Login successful!');
        }

        // 4. Failed login
        return back()->with('error', 'Invalid credentials or account inactive')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Destroy session (important security step)
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('login.index')->with('success', 'Good Bye');

    }



}
