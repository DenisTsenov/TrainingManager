<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DashboardController extends Controller
{
    public function forDistribution(Request $request): DataTableCollectionResource
    {
        $length  = $request->input('length');
        $sortBy  = $request->input('column');
        $orderBy = $request->input('dir');
        $search  = $request->input('search');

        $query = User::eloquentQuery($sortBy, $orderBy, $search, ['sport', 'settlement'])
                     ->notAdmin()
                     ->whereNull('team_id')
                     ->whereNull('role_id');

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function createDistribution(User $user): View
    {
        $user->load('sport:id,name', 'settlement:id,name');
        $teams = Team::withoutTrashed()
                     ->select('id', 'name', 'trainer_id', 'created_at')
                     ->with('trainer:id,full_name')
                     ->withCount('members')
                     ->where('sport_id', $user->sport_id)
                     ->where('settlement_id', $user->settlement_id)
                     ->get();

        return view('auth.admin.distribution.distribute', [
            'user'  => $user,
            'teams' => $teams->count() ? $teams : null,
        ]);
    }

    public function storeDistribution(Request $request)
    {

    }
}
