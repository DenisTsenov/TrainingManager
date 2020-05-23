<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $request->validate([
            'term' => ['required', 'string',],
        ]);

        $user = User::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name, role_id")
                    ->whereLike($request->input('term'))
                    ->orderByRaw('first_name ASC, last_name ASC')
                    ->limit(5)
                    ->get();

        return \response()->json($user);
    }

    /**
     * @param User    $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeRole(User $user, Request $request)
    {
        $request->validate([
            'user' => ['required', 'integer', 'exists:users,id'],
            'role' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $user->update(['role_id' => $request->input('role')]);

        return \response()->json(true);
    }
}
