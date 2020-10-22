<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    protected $table = 'personal_data';

    protected $fillable = ['user_id', 'sport_id', 'settlement_id'];
}
