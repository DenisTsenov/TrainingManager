<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Settlement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
    public function index(): JsonResponse
    {
        $settlements = Settlement::query()->orderBy('name')->pluck('name', 'id');

        return response()->json($settlements);
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

    public function update(Request $request)
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
