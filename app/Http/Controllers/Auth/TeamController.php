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
use Illuminate\Support\Facades\Auth;

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
            User::createOrUpdateHistory($team, $request->input('members'));
        }, 5);

        session()->flash('success', 'Operation done successfully!');

        return response()->json(['route' => route('admin.team')]);
    }

    public function edit(Team $team): View
    {
        $team->load(['trainer']);

        $team->members = User::selectRaw('id,full_name,sport_id,settlement_id,team_id,created_at')
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

        $route        = route('admin.team.update', compact('team'));
        $destroyRoute = route('admin.team.destroy', compact('team'));
        $canDestroy   = Auth::user()->can('delete', $team);

        return view('auth.team.create_edit', [
            'team'         => $team,
            'route'        => $route,
            'destroyRoute' => $destroyRoute,
            'canDestroy'   => $canDestroy,
            'edit'         => true,
        ]);
    }

    public function update(TeamRequest $request, Team $team): JsonResponse
    {
        DB::transaction(function () use ($request, $team) {
            $requestTrainer = $request->input('trainer_id');
            User::createOrUpdateHistory($team, $request->input('members'), $requestTrainer);

            if ($team->trainer_id <> $requestTrainer) {
                User::where('id', $team->trainer_id)->update(['team_id' => null]);
                User::where('id', $requestTrainer)->update(['team_id' => $team->id]);
            }

            $team->update([
                'name'       => $request->input('name'),
                'trainer_id' => $request->input('trainer_id'),
            ]);

            User::createOrUpdateMembership($request->input('members'), $team->id);
        }, 5);

        session()->flash('success', 'Operation done successfully!');

        return response()->json(['route' => route('admin.team')]);
    }

    public function destroy(Team $team)
    {
        DB::transaction(function () use ($team) {
            User::where('team_id', $team->id)->update(['team_id' => null]);

            $team->delete();
        }, 5);

        session()->flash('success', 'Operation done successfully!');

        return response()->json(['route' => route('admin.team')]);
    }

    public function history(Team $team)
    {
        $team->load('exMembers', 'createdBy');

        return view('auth.team.history', compact('team'));
    }
}
