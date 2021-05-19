<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class AjaxController extends Controller
{
    public function getTrainers()
    {
        return User::trainers()->with(['sport', 'settlement'])->get()->toJson();
    }
}
