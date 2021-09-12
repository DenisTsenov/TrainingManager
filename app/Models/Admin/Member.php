<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'team_members';

    protected $fillable = ['team_id', 'competitor_id', 'joined_at', 'left_at'];

    protected $dates = ['joined_at', 'left_at'];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Member $member) {
            $member->joined_at = now();
            $member->left_at   = now();
        });
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function competitors()
    {
        return $this->hasMany(User::class, 'competitor_id');
    }
}
