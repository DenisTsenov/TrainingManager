<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settlement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class SettlementController extends Controller
{
    public function withSports(): JsonResponse
    {
        $settlements = Settlement::has('sports')->orderBy('name')->pluck('name', 'id');

        return response()->json($settlements);
    }

    public function index()
    {
        return view('auth.admin.settlements.list');
    }

    public function list(Request $request)
    {
        $length  = $request->input('length');
        $sortBy  = $request->input('column');
        $orderBy = $request->input('dir', 'desc');
        $search  = $request->input('search');

        $query = Settlement::eloquentQuery($sortBy, $orderBy, $search, ['createdBy'])->withCount('sports');
        $data  = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        return view('auth.admin.settlements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:settlements,name',
        ]);

        Settlement::create(['name' => $request->input('name')]);

        return response()->json();
    }

    public function edit(Request $request)
    {

    }

    public function update(Request $request, Settlement $settlement)
    {

    }

    public function sports(Request $request): JsonResponse
    {
        $request->validate([
            'settlement_id' => ['required', 'exists:settlements,id'],
        ]);

        $sports = Settlement::find($request->input('settlement_id'))->sports()->pluck('sports.name', 'sports.id');

        return response()->json($sports);
    }
}
