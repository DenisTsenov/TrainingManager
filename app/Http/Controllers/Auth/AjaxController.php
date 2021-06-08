<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Sport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function getTrainers()
    {
        return User::trainers()->with(['sport', 'settlement'])->get()->toJson();
    }

    public function getSports(Request $request)
    {
        $request->validate(['settlement_id' => 'nullable', 'exists:users,id']);

        $sports = Sport::select('id', 'name')->get();

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
}
