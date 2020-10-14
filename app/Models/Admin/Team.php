<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = ['trainer_id'];

    protected $dates = ['created_at'];

    public $timestamps = false;

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
