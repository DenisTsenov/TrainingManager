<?php

namespace App\Policies;

use App\Models\Admin\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        $trainers    = User::trainers()->pluck('id');
        $trainersIds = Team::distinct('trainer_id')->pluck('trainer_id');

        return $trainers->diff($trainersIds)->isNotEmpty();
    }

    public function delete(User $user, Team $team): bool
    {
        $members = User::notTrainers()->where('team_id', $team->id)->get();

        return $members->count() == 0 && now()->diffInDays($team->created_at) >= 1;
    }
}
