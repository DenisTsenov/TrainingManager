<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageRolesController extends Controller
{
    public function index()
    {
        return view('auth.admin.index');
    }
}
