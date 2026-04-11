<?php

namespace App\Http\Controllers\admin\Profile;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;

class ProfileController extends Controller
{
    const page ="Profile";
    const viewPath = "admin.template1.profile.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    public function update(Request $request)
    {

        $user_detail = User::getUserByEmail(Auth::user()->email);
        $user_detail->name = $request->name;
        $user_detail->dob = date("Y-m-d",strtotime($request->dob));
        $user_detail->phone = $request->phone;
        $user_detail->role = $request->role;
        $user_detail->address = $request->address;
        $user_detail->linkedIn_url = $request->linkedIn_url;
        $user_detail->about = $request->about;

        $user_detail->update();

        return redirect()->route('profile.view')->with('success', 'Edit Successfully');

    }


    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        $user_detail = User::getUserByEmail(Auth::user()->email);

        return view(self::viewPath . 'index', compact('breadcrumbs','user_detail'));
    }


// Controller
    public function upload_img(Request $request)
    {
        try
        {
            $request->validate([
                'uploadImg' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
            ]);

            $file = $request->file('uploadImg');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Create directory if it doesn't exist
            if (!file_exists(public_path('uploads')))
            {
                mkdir(public_path('uploads'), 755, true);
            }

            $file->move(public_path('uploads'), $filename);

            $user_detail = User::getUserByEmail(Auth::user()->email);
            $user_detail->image = asset('uploads/' . $filename);
            $user_detail->update();

            return response()->json([
                'success' => true,
                'url' => asset('uploads/' . $filename)
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json(['success' => false,'message' => $e->getMessage()], 500);
        }
    }

}
