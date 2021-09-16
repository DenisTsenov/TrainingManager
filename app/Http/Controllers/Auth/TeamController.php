<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TeamRequest;
use App\Models\Admin\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('auth.team.index', ['route' => route('admin.team.create')]);
    }

    public function list(Request $request): DataTableCollectionResource
    {
        $length  = $request->input('length');
        $sortBy  = $request->input('column');
        $orderBy = $request->input('dir');
        $search  = $request->input('search');

        $query = Team::eloquentQuery($sortBy, $orderBy, $search, ['sport', 'trainer', 'settlement']);
        $data  = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function create(): View
    {
        $route = route('admin.team.store');

        return view('auth.team.create_edit', compact('route'));
    }

    public function store(TeamRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $trainer = User::find($request->input('trainer_id'));

            $team = Team::create([
                'name'          => $request->input('name'),
                'trainer_id'    => $request->input('trainer_id'),
                'sport_id'      => $trainer->sport->id,
                'settlement_id' => $trainer->settlement->id,
            ]);

            $trainer->update(['team_id' => $team->id]);

            User::createOrUpdateMembership($request->input('members'), $team->id);
        }, 5);

        return response()->json(['route' => route('admin.team')]);
    }

    public function edit(Team $team): View
    {
        $team->load(['trainer']);

        $membersAndUsers = User::selectRaw('id,full_name,sport_id,settlement_id,team_id,created_at')
                               ->where(function ($query) use ($team) {
                                   $query->where('team_id', $team->id)
                                         ->orWhere(function ($query) use ($team) {
                                             $query->whereNull('team_id')
                                                   ->where('sport_id', $team->sport_id)
                                                   ->where('settlement_id', $team->settlement_id);
                                         })
                                         ->notAdmin()
                                         ->notTrainers();
                               })
                               ->with(['sport', 'settlement'])
                               ->get();

        $team->members = $membersAndUsers;

        $route = route('admin.team.update', compact('team'));

        return view('auth.team.create_edit', ['team' => $team, 'route' => $route, 'edit' => true]);
    }

    public function update(TeamRequest $request, Team $team): JsonResponse
    {
        DB::transaction(function () use ($request, $team) {
            $trainer = User::find($request->input('trainer_id'));

            $team->update([
                'name'          => $request->input('name'),
                'trainer_id'    => $request->input('trainer_id'),
                'sport_id'      => $trainer->sport->id,
                'settlement_id' => $trainer->settlement->id,
            ]);

            User::createOrUpdateMembership($request->input('members'), $team->id);
        }, 5);

        return response()->json(['route' => route('admin.team')]);
    }
}
