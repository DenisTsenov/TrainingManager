<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = ['trainer_id'];

    public function trainer()
    {
        return $this->hasOne(User::class, 'trainer_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
