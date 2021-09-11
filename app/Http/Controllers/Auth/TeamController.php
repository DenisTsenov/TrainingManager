<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TeamRequest;
use App\Models\Admin\Team;
use App\Models\User;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index()
    {
        return view('auth.team.index', ['route' => route('admin.team.create')]);
    }

    public function list(Request $request)
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
        $trainer = User::find($request->input('trainer_id'));

        DB::transaction(function () use ($request) {
            $trainer = User::find($request->input('trainer_id'));

            $team = Team::create([
                'name'          => $request->input('name'),
                'trainer_id'    => $request->input('trainer_id'),
                'sport_id'      => $trainer->sport->id,
                'settlement_id' => $trainer->settlement->id,
            ]);

            $members = [];

            foreach ($request->input('members') as $member) {
                array_push($members, ['competitor_id' => $member]);
            }

            $team->members()->createMany($members);
        }, 5);

        return response()->json(['route' => route('admin.team')]);
    }

    public function edit(Team $team)
    {
        $team->load('trainer');
        $route = route('admin.team.update', compact('team'));

        return view('auth.team.create_edit', compact('team', 'route'));
    }

    public function update(TeamRequest $request, Team $team)
    {
        $trainer = User::find('id', $request->input('trainer_id'));

        $team->update([
            'name'          => $request->input('name'),
            'trainer_id'    => $request->input('trainer_id'),
            'sport_id'      => $trainer->sport->id,
            'settlement_id' => $trainer->settlement->id,
        ]);

        return response()->json(['route' => route('admin.team')]);
    }
}
