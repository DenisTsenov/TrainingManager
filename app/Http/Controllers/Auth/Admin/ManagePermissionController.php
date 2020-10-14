<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Admin\Permission;
use App\Http\Controllers\Controller;

class ManagePermissionController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['permissions' => Permission::all()]);
    }
}
