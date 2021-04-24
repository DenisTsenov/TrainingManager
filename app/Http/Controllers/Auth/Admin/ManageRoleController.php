<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageRoleController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['roles' => Role::all()]);
    }

    public function togglePermission(Request $request)
    {
        $request->validate([
            'role'       => ['required', 'integer', 'exists:roles,id'],
            'permission' => ['required', 'integer', 'exists:permissions,id'],
        ]);

        Role::find($request->input('role'))->permissions()->toggle($request->input(['permission']));

        return response()->json(['success' => true]);
    }
}
