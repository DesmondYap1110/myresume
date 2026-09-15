<?php

namespace App\Http\Controllers\admin\Profile;

use App\Http\Controllers\Controller;
use App\Support\SafeImageUpload;
use Illuminate\Validation\ValidationException;
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

            $path = SafeImageUpload::store($request->file('uploadImg'), 'uploads', 'uploadImg');

            $user_detail = User::getUserByEmail(Auth::user()->email);
            // Stored as a path so it works on any host; User::getImageAttribute builds the URL.
            $user_detail->image = $path;
            $user_detail->update();

            return response()->json([
                'success' => true,
                'url' => asset($path)
            ]);
        }
        catch (ValidationException $e)
        {
            return response()->json(['success' => false,'message' => collect($e->errors())->flatten()->first()], 422);
        }
        catch (\Exception $e)
        {
            return response()->json(['success' => false,'message' => $e->getMessage()], 500);
        }
    }

}
