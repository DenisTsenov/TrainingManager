<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const TRAINER    = 1;
    const COMPETITOR = 2;

    protected $table = 'roles';

    protected $fillable = ['name'];

    protected $with = ['permissions'];

//    protected $hidden = ['pivot'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
