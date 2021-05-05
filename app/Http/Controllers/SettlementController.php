<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function index(): JsonResponse
    {
        $settlements = Settlement::query()->orderBy('name')->pluck('name', 'id');

        return response()->json($settlements);
    }

    public function sports(Request $request)
    {
        $request->validate([
            'settlement_id' => ['required', 'exists:settlements,id'],
        ]);

        $sports = Settlement::find($request->input('settlement_id'))->sports()->pluck('sports.name', 'sports.id');

        return response()->json($sports);
    }
}
