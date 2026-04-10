<?php

namespace App\Http\Controllers\admin\Inbox;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    const page ="Inbox";
    const viewPath = "admin.template1.inbox.";

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

    public function edit()
    {
        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit'))->get();

        return view(self::viewPath . 'edit', compact('breadcrumbs'));
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();

        return view(self::viewPath . 'index', compact('breadcrumbs'));
    }

    public function viewmessage()
    {
        $breadcrumbs = $this->breadcrumbs->add('View '.self::page, route($this->route.'view.message',request()->id))->get();

        return view(self::viewPath . 'viewmessage', compact('breadcrumbs'));

    }
}
