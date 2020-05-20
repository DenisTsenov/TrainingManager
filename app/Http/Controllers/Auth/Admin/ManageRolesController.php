<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageRolesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.admin.index', ['roles' => Role::get()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Request $request)
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
}
