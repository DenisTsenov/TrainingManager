<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        return view('auth.admin.distribute', compact('user'));
    }

    public function storeDistribution(Request $request)
    {

    }
}
