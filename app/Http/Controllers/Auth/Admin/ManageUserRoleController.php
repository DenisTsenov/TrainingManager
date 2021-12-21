<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUserRoleController extends Controller
{
    public function __construct()
    {
        $this->setActiveMenu(self::MENU_ADMIN);

        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $this->setActiveSubMenu(self::SUB_MENU_MANAGE_USER_ROLES_PERMISSIONS);

        return view('auth.admin.manage_user_role', ['roles' => Role::get()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['term' => ['required', 'string']]);

        $users = User::selectRaw("id, full_name, role_id")
                     ->like($request->input('term'))
                     ->whereNull('team_id')
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
    public function changeRole(User $user, Request $request): \Illuminate\Http\JsonResponse
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
