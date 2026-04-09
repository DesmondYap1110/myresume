<?php

namespace App\Http\Controllers\admin\Inbox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    private function setbreadcrumbs()
    {
        return [
            "CurrentPage" => "Inbox",
            "isDashboard" => true,
            "CurrentUrl"  => route("inbox.view"),
            "homeUrl" => route("dashboard.view"),
        ];
    }

    public function index()
    {
        //Set Breadcrumbs
        $breadcrumbs = $this->setbreadcrumbs();

        return view('admin.template1.inbox.index',compact('breadcrumbs'));
    }
}
