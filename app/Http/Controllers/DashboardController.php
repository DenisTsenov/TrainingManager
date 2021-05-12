<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DashboardController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function forDistribution(Request $request)
    {
        $length  = $request->input('length');
        $sortBy  = $request->input('column');
        $orderBy = $request->input('dir');
        $search  = $request->input('search');

        $query = User::eloquentQuery($sortBy, $orderBy, $search, ['sport', 'settlement'])
                     ->notAdmin()
                     ->whereNull('role_id')
                     ->doesntHave('membership');

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }
}
