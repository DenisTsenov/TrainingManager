<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

     protected $table = 'sports';

     protected $fillable = ['name'];
}
