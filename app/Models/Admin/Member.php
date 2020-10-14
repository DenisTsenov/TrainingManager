<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'team_members';

    protected $fillable = ['team_id', 'competitor_id'];

    protected $dates = ['joined_at', 'left_at'];

    public $timestamps = false;

    public function competitors()
    {
        return $this->hasMany(User::class, 'competitor_id');
    }
}
