<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Events\SportToggled;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\SportRequest;
use App\Models\Admin\Sport;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use App\Enums\Menu;

class SportController extends Controller
{
    public function __construct()
    {
        $this->setActiveMenu(Menu::ADMIN->value);

        parent::__construct();
    }

    public function index()
    {
        $this->setActiveSubMenu(Menu::SUB_MENU_SPORTS->value, Menu::SUB_MENU_SPORTS_LIST->value);

        return view('auth.admin.sports.list', ['route' => route('admin.sport.list')]);
    }

    public function list(Request $request): DataTableCollectionResource
    {
        $this->setActiveSubMenu(Menu::SUB_MENU_SPORTS->value, Menu::SUB_MENU_SPORTS_LIST->value);

        $length  = $request->input('length');
        $orderBy = $request->input('column');
        $dir     = $request->input('dir', 'desc');
        $search  = $request->input('search');

        $query = Sport::eloquentQuery($orderBy, $dir, $search, ['createdBy'])
                      ->withCount(['settlements' => fn($query) => $query->withTrashed()])
                      ->when($orderBy == 'settlements_count', fn($query) => $query->reorder($orderBy, $dir))
                      ->withTrashed();

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        $this->setActiveSubMenu(Menu::SUB_MENU_SPORTS->value, Menu::SUB_MENU_SPORT_CREATE_EDIT->value);

        return view('auth.admin.sports.create_edit', ['route' => route('admin.sport.store')]);
    }

    public function store(SportRequest $request)
    {
        Sport::create($request->validated());

        session()->flash('success', 'Operation done successfully!');

        return response()->json(['route' => route('admin.sport')]);
    }

    public function edit(Sport $sport)
    {
        $this->setActiveSubMenu(Menu::SUB_MENU_SPORTS->value, Menu::SUB_MENU_SPORT_CREATE_EDIT->value);

        return view('auth.admin.sports.create_edit', [
            'route' => route('admin.sport.update', ['sport' => $sport]),
            'sport' => $sport,
        ]);
    }

    public function update(SportRequest $request, Sport $sport)
    {
        $sport->update($request->validated());

        session()->flash('success', 'Operation done successfully!');

        return response()->json(['route' => route('admin.sport')]);
    }

    public function toggleActivation(Sport $sport)
    {
        if ($deleted = is_null($sport->deleted_at)) {
            $sport->delete();
        } else {
            $deleted = $sport->deleted_at = null;
            $sport->save();
        }

        event(new SportToggled());

        return response()->json(['deleted' => $deleted]);
    }
}
