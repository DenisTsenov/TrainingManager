<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Sport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function trainers(): string
    {
        return User::trainers()->with(['sport', 'settlement'])->get()->toJson();
    }

    public function sports(Request $request): string
    {
        $request->validate(['settlement_id' => 'nullable', 'exists:users,id']);

        $sports = Sport::withTrashed()->select('id', 'name', 'deleted_at')->get();

        $currentSports = DB::table('settlement_sport')->where('settlement_id', $request->input('settlement_id'))->get();

        if ($currentSports->isNotEmpty()) {
            foreach ($sports as $sport) {
                foreach ($currentSports as $currentSport) {
                    if ($sport->id == $currentSport->sport_id) {
                        $sport->checked = true;
                        break;
                    }
                }
            }
        }

        return $sports->toJson();
    }

    public function teamUsers(User $trainer)
    {
        return User::with('sport', 'settlement')
                   ->where('settlement_id', $trainer->settlement_id)
                   ->where('sport_id', $trainer->sport_id)
                   ->forDistribution()
                   ->get()
                   ->toJson();
    }
}
