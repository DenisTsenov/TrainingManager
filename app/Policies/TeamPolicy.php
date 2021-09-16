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

    public function create(User $user)
    {
        $trainers    = User::trainers()->pluck('id');
        $trainersIds = Team::distinct('trainer_id')->pluck('trainer_id');

        return $trainers->diff($trainersIds)->isNotEmpty();
    }
}
