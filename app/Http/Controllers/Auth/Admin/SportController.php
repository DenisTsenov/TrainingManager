<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class SportController extends Controller
{
    public function list(Request $request)
    {
        $length  = $request->input('length');
        $sortBy  = $request->input('column');
        $orderBy = $request->input('dir');
        $search  = $request->input('search');

        $query = Sport::eloquentQuery($sortBy, $orderBy, $search);
        $data  = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        return view('auth.admin.sports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sports,name',
        ]);

        Sport::create(['name' => $request->input('name')]);

        return response()->json();
    }

    public function edit(Request $request)
    {

    }

    public function update(Request $request)
    {

    }
}
