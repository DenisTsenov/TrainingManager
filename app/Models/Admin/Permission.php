<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    const CREATE_TRAINING   = 1;
    const ASSIGN_TRAINING   = 2;
    const EDIT_TRAINING     = 3;
    const ROLLBACK_TRAINING = 4;
    const TRAINING_COMPLETE = 5;

    protected $table = 'permissions';

    protected $fillable = ['name'];

    protected $hidden = ['pivot'];
}
