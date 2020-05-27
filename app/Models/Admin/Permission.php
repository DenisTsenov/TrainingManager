<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = ['name'];

    protected $hidden = ['pivot'];
}
