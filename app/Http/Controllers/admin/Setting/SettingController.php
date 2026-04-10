<?php

namespace App\Http\Controllers\admin\Setting;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    const page ="Setting";
    const viewPath = "admin.template1.setting.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }


    public function update()
    {

    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        return view(self::viewPath . 'index', compact('breadcrumbs'));
    }
}
