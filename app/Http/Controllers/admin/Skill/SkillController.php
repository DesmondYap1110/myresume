<?php

namespace App\Http\Controllers\admin\Skill;

use App\Helpers\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkillController extends Controller
{
    const page = "Skill";
    const viewPath = "admin.template1.skill.";

    protected $breadcrumbs;
    protected $route;

    public function __construct()
    {
        $this->route = strtolower(self::page).".";
        $this->breadcrumbs = (new Breadcrumb())->setPage(self::page, route($this->route.'view'));
    }

    private function rules(): array
    {
        return [
            'name'  => 'required|max:255',
            'level' => 'required|integer|min:0|max:100',
        ];
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $skill = Skill::getSkillByUserid(Auth::id());

        return view(self::viewPath.'index', compact('breadcrumbs', 'skill'));
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->rules());

        $skill = new Skill();
        $skill->user_id = Auth::id();
        $skill->name    = $data['name'];
        $skill->level   = $data['level'];
        // New skills go to the bottom; the list is ordered by dragging.
        $skill->sort_order = (int) Skill::where('user_id', Auth::id())->max('sort_order') + 1;
        $skill->save();

        return redirect()->route($this->route.'view')->with('success', __('admin.flash.added', ['item' => __('admin.menu.skill')]));
    }

    public function update(Request $request)
    {
        $skill = Skill::getSkillById(Auth::id(), request()->id);
        if (!$skill) abort(404);

        $data = $request->validate($this->rules());

        $skill->name  = $data['name'];
        $skill->level = $data['level'];
        $skill->update();

        return redirect()->route($this->route.'view')->with('success', __('admin.flash.updated', ['item' => __('admin.menu.skill')]));
    }

    /**
     * New order from dragging rows. Only ids belonging to the signed-in
     * account are touched, so nobody can reorder someone else's list.
     */
    public function reorder(Request $request)
    {
        $ids = collect($request->input('ids', []))->map(fn ($id) => (int) $id)->filter()->all();

        $owned = Skill::where('user_id', Auth::id())->pluck('id')->all();

        DB::transaction(function () use ($ids, $owned) {
            $position = 0;
            foreach ($ids as $id) {
                if (in_array($id, $owned, true)) {
                    Skill::where('user_id', Auth::id())->where('id', $id)->update(['sort_order' => $position++]);
                }
            }
        });

        return response()->json(['ok' => true]);
    }

    public function delete()
    {
        $skill = Skill::getSkillById(Auth::id(), request()->id);
        if (!$skill) abort(404);

        $skill->delete();

        return redirect()->route($this->route.'view')->with('success', __('admin.flash.deleted', ['item' => __('admin.menu.skill')]));
    }
}
