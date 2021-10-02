<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Sport;
use App\Models\Admin\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function trainers(Request $request): string
    {
        $request->validate(['trainer_id' => ['nullable', 'exists:users,id']]);

        if ($request->has('trainer_id')) {
            $trainer       = User::firstWhere('id', $request->trainer_id);
            $takenTrainers = Team::where('trainer_id', '<>', $trainer->id)
                                 ->where('sport_id', $trainer->sport_id)
                                 ->where('settlement_id', $trainer->settlement_id)
                                 ->distinct('trainer_id')
                                 ->pluck('trainer_id');

            if ($trainer->exists) {
                return User::query()
                           ->trainers()
                           ->where(function ($query) use ($trainer, $takenTrainers) {
                               $query->whereNotIn('id', $takenTrainers)
                                     ->where('sport_id', $trainer->sport_id)
                                     ->where('settlement_id', $trainer->settlement_id);
                           })
                           ->with(['sport', 'settlement'])
                           ->get()
                           ->toJson();
            }
        }

        $trainersIds = Team::distinct('trainer_id')->pluck('trainer_id');

        return User::trainers()
                   ->whereNotIn('id', $trainersIds)
                   ->with(['sport', 'settlement'])
                   ->get()
                   ->toJson();
    }

    public function sports(Request $request): string
    {
        $request->validate(['settlement_id' => ['nullable', 'exists:settlements,id']]);

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
