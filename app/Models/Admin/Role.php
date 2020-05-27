<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name'];

    protected $with = ['permissions'];

    protected $hidden = ['pivot'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
