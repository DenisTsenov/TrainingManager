<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\SettlementRequest;
use App\Models\Admin\Settlement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use App\Enums\Menu;

class SettlementController extends Controller
{
    public function __construct()
    {
        View::composer('auth.admin.settlements.create_edit', fn($view) => $view->with('sportsUrl', route('admin.sports')));
        $this->setActiveMenu(Menu::ADMIN->value);

        parent::__construct();
    }

    public function withSports(): JsonResponse
    {
        $settlements = Settlement::with('sports')->has('sports')->orderBy('name')->pluck('name', 'id');

        return response()->json($settlements);
    }

    public function index()
    {
        $this->setActiveSubMenu(Menu::SUB_MENU_SETTLEMENTS->value, Menu::SUB_MENU_SETTLEMENTS_LIST->value);

        return view('auth.admin.settlements.list', ['activeSubMenu' => $this->getActiveSubMenu()]);
    }

    public function list(Request $request): DataTableCollectionResource
    {
        $this->setActiveSubMenu(Menu::SUB_MENU_SETTLEMENTS->value, Menu::SUB_MENU_SETTLEMENTS_LIST->value);

        $length  = $request->input('length');
        $orderBy = $request->input('column');
        $dir     = $request->input('dir', 'desc');
        $search  = $request->input('search');

        $query = Settlement::eloquentQuery($orderBy, $dir, $search, ['createdBy'])
                           ->withCount(['sports' => fn($query) => $query->withTrashed()])
                           ->when($orderBy == 'sports_count', fn($query) => $query->reorder($orderBy, $dir));

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        $this->setActiveSubMenu(Menu::SUB_MENU_SETTLEMENTS->value, Menu::SUB_MENU_SETTLEMENT_CREATE_EDIT->value);

        return view('auth.admin.settlements.create_edit', ['route' => route('admin.settlement.store')]);
    }

    public function store(SettlementRequest $request)
    {
        \DB::transaction(function () use ($request) {
            $settlement = Settlement::create(['name' => $request->input('name')]);

            $settlement->sports()->attach($request->input('sports'));
        });
        session()->flash('success', 'Operation done successfully!');

        return response()->json(['route' => route('admin.settlement')]);
    }

    public function edit(Settlement $settlement)
    {
        $this->setActiveSubMenu(Menu::SUB_MENU_SETTLEMENTS->value, Menu::SUB_MENU_SETTLEMENT_CREATE_EDIT->value);

        $route = route('admin.settlement.update', ['settlement' => $settlement]);

        return view('auth.admin.settlements.create_edit', ['route' => $route, 'settlement' => $settlement]);
    }

    public function update(SettlementRequest $request, Settlement $settlement)
    {
        \DB::transaction(function () use ($settlement, $request) {
            $settlement->update(['name' => $request->input('name'),]);

            $settlement->sports()->sync($request->input('sports'));
        });
        session()->flash('success', 'Operation done successfully!');

        return response()->json(['route' => route('admin.settlement')]);
    }

    public function sports(Request $request): JsonResponse
    {
        $request->validate(['settlement_id' => ['required', 'exists:settlements,id'],]);

        $sports = Settlement::find($request->input('settlement_id'))->sports()->pluck('sports.name', 'sports.id');

        return response()->json($sports);
    }
}
