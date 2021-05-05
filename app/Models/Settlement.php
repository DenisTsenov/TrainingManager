<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

     protected $table = 'settlements';

     protected $fillable = ['name'];

     public function sports()
     {
         return $this->belongsToMany(Sport::class);
     }
}
