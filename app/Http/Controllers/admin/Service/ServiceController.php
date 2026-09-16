<?php

namespace App\Http\Controllers\admin\Service;

use App\Helpers\Breadcrumb;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    const page = "Service";
    const viewPath = "admin.template1.service.";

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
            'title'       => 'required|max:255',
            'icon'        => ['required', Rule::in(array_keys((array) config('service_icons', [])))],
            'description' => 'required|max:1000',
            'sort_order'  => 'nullable|integer|min:0|max:999',
        ];
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->get();
        $service = Service::getServiceByUserid(Auth::id());
        $icons = (array) config('service_icons', []);

        return view(self::viewPath.'index', compact('breadcrumbs', 'service', 'icons'));
    }

    public function add()
    {
        $breadcrumbs = $this->breadcrumbs->add('Add '.self::page, route($this->route.'add'))->get();
        $icons = (array) config('service_icons', []);

        return view(self::viewPath.'add', compact('breadcrumbs', 'icons'));
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->rules());

        $service = new Service();
        $service->user_id     = Auth::id();
        $service->title       = $data['title'];
        $service->icon        = $data['icon'];
        $service->description = $data['description'];
        $service->sort_order  = $data['sort_order'] ?? 0;
        $service->save();

        return redirect()->route($this->route.'view')->with('success', 'Add Service successful!');
    }

    public function edit()
    {
        $breadcrumbs = $this->breadcrumbs->add('Edit '.self::page, route($this->route.'edit', request()->id))->get();

        $service_detail = Service::getServiceById(Auth::id(), request()->id);
        if (!$service_detail) abort(404);

        $icons = (array) config('service_icons', []);

        return view(self::viewPath.'edit', compact('breadcrumbs', 'service_detail', 'icons'));
    }

    public function update(Request $request)
    {
        $service = Service::getServiceById(Auth::id(), request()->id);
        if (!$service) abort(404);

        $data = $request->validate($this->rules());

        $service->title       = $data['title'];
        $service->icon        = $data['icon'];
        $service->description = $data['description'];
        $service->sort_order  = $data['sort_order'] ?? 0;
        $service->update();

        return redirect()->route($this->route.'view')->with('success', 'Edit Service successful!');
    }

    public function delete()
    {
        $service = Service::getServiceById(Auth::id(), request()->id);
        if (!$service) abort(404);

        $service->delete();

        return redirect()->route($this->route.'view')->with('success', 'Delete Service successful!');
    }
}
