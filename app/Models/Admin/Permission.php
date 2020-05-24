<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = ['name'];

    public function getNameAttribute($value)
    {
//        return Str::of($value)->replace('_', ' ')->title();
        return ucfirst(str_replace('_', ' ', $value));
    }

}
