<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TeamRequest;
use App\Models\Admin\Team;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class TeamController extends Controller
{
    public function index()
    {
        return view('auth.team.index', ['route' => route('admin.team.create')]);
    }

    public function teamsList(Request $request)
    {
        $length  = $request->input('length');
        $sortBy  = $request->input('column');
        $orderBy = $request->input('dir');
        $search  = $request->input('search');

        $query = Team::eloquentQuery($sortBy, $orderBy, $search, ['sport', 'trainer', 'settlement']);
        $data  = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        $route = route('admin.team.store');

        return view('auth.team.create_edit', compact('route'));
    }

    public function store(TeamRequest $request)
    {
        Team::create($request->validated());

        return response()->json(['route' => route('admin.team')]);
    }

    public function edit(Team $team)
    {
        $team->load('trainer');

        $route = route('admin.team.update', $team);

        return view('auth.team.create_edit', compact('team', 'route'));
    }

    public function update(TeamRequest $request, Team $team)
    {
        dd($request->all());
    }
}
