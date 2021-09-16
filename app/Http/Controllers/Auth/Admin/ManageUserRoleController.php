<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUserRoleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.admin.manage_user_role', ['roles' => Role::get()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findUser(Request $request)
    {
        $request->validate(['term' => ['required', 'string',],]);

        $users = User::selectRaw("id, full_name, role_id")
                     ->like($request->input('term'))
                     ->orderByRaw('first_name ASC, last_name ASC')
                     ->limit(5)
                     ->get();

        return \response()->json($users);
    }

    /**
     * @param User    $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeRole(User $user, Request $request)
    {
        $request->validate(['role' => ['required', 'integer', 'exists:roles,id']]);

        $role     = $request->input('role');
        $response = 'new role';

        if ($request->input('role') == ($user->role->id ?? null)) {
            $role     = null;
            $response = 'no role';
        }

        $user->update(['role_id' => $role]);

        return \response()->json($response);
    }
}
