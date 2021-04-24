<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlemet extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

     protected $table = 'settlements';

     protected $fillable = ['name'];
}
