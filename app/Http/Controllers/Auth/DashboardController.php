<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\Admin\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use App\Http\Requests\Auth\Admin\StoreDistributionRequest;
use App\Enums\Menu;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->setActiveMenu(Menu::WELCOME->value);

        parent::__construct();
    }

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
            'route' => route('admin.distribute.store'),
        ]);
    }

    public function storeDistribution(StoreDistributionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::find($request->input('user_id'));

            $user->update([
                'team_id' => $request->input('team_id'),
                'role_id' => $user->role_id ?? Role::COMPETITOR,
            ]);

            $user->historyMembership()
                 ->attach($request->input('team_id'), [
                     'joined_at'    => now(),
                     'current_role' => config('constants.roles.' . ($member->role_id ?? Role::COMPETITOR)),
                 ]);
        });

        session()->flash('success', 'User was distributed successfully!');

        return response()->json(['route' => route('welcome')]);
    }
}
