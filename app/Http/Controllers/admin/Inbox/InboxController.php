<?php

namespace App\Http\Controllers\admin\Inbox;

use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inbox;

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


    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $inbox = Inbox::getInboxByUserid(Auth::user()->id);

        return view(self::viewPath . 'index', compact('breadcrumbs','inbox'));
    }

    /**
     * Polled from the navbar so the unread badge updates without a page
     * reload. Kept deliberately small: a count query plus a handful of
     * rows, not the full inbox.
     */
    public function unread()
    {
        $userId = Auth::id();

        $items = Inbox::getInboxByUseridStatus($userId, Inbox::read_status_inactive, 8)
            ->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'subject' => \Illuminate\Support\Str::words($item->subject, 4, '...'),
                'time' => $item->created_at->diffForHumans(),
                'url' => route('inbox.view.message', $item->id),
            ]);

        return response()->json([
            'count' => Inbox::countUnreadByUserid($userId),
            'items' => $items,
        ]);
    }

    public function delete()
    {

        $inbox = Inbox::getInboxtById(Auth::id(),request()->id);
        $inbox->delete();

        return redirect()->route('inbox.view')->with('success', 'Delete Message successful!');

    }

    public function viewmessage()
    {
        $breadcrumbs = $this->breadcrumbs->add('View '.self::page, route($this->route.'view.message',request()->id))->get();
        $inbox = Inbox::getInboxtById(Auth::user()->id,request()->id);
        if(!$inbox) abort(404);

        if($inbox->read_status == Inbox::read_status_inactive)
        {
            $inbox = Inbox::findOrFail(request()->id);

            $inbox->read_status = Inbox::read_status_active;
            $inbox->save();
        }


        return view(self::viewPath . 'viewmessage', compact('breadcrumbs','inbox'));
    }

    public function status(Request $request)
    {

        $inbox = Inbox::findOrFail(request()->id);

        $inbox->read_status = !$inbox->read_status;
        $inbox->save();

        return redirect()->route('inbox.view')->with('success', 'Update Read Status successful!');
    }

    public function editstatus($id)
    {

        $inbox = Inbox::findOrFail(request()->id);

        $inbox->read_status = !$inbox->read_status;
        $inbox->save();

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully'
        ]);
    }
    public function readAll()
    {
        $inbox= Inbox::getInboxByUseridStatus(Auth::user()->id);
        $inbox->each->update(['read_status'=> inbox::read_status_active]);
        return redirect()->route('inbox.view')->with('success', 'Update Read Status successful!');
    }
}
