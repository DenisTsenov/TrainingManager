<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name'];

    public function getNameAttribute($value)
    {
        return Str::title($value);
    }
}
