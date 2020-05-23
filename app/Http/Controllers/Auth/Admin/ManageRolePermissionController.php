<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageRolePermissionController extends Controller
{
    public function index()
    {
        return view('auth.admin.manage_role_permission', ['permissions' => Permission::get() ]);
    }
}
