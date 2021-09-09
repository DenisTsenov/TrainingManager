<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Events\SportToggled;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\SportRequest;
use App\Models\Admin\Sport;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class SportController extends Controller
{
    public function index()
    {
        $route = route('admin.sport.list');

        return view('auth.admin.sports.list', compact('route'));
    }

    public function list(Request $request)
    {
        $length  = $request->input('length');
        $sortBy  = $request->input('column');
        $orderBy = $request->input('dir', 'asc');
        $search  = $request->input('search');

        $query = Sport::eloquentQuery($sortBy, $orderBy, $search, ['createdBy'])
                      ->withCount(['settlements' => fn($query) => $query->withTrashed()])
                      ->when($sortBy == 'settlements_count', fn($query) => $query->reorder($sortBy, $orderBy))
                      ->withTrashed();

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        $route = route('admin.sport.store');

        return view('auth.admin.sports.create_edit', compact('route'));
    }

    public function store(SportRequest $request)
    {
        Sport::create($request->validated());

        session()->flash('success', 'Operation done successfully!');

        return response()->json(['route' => route('admin.sport')]);
    }

    public function edit(Sport $sport)
    {
        $route = route('admin.sport.update', ['sport' => $sport]);

        return view('auth.admin.sports.create_edit', compact('route', 'sport'));
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

        return response()->json(compact('deleted'));
    }
}
