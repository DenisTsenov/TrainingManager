<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Requests\Auth\Admin\SportToggleRequest;
use App\Models\Admin\Role;
use App\Http\Controllers\Controller;

class ManageRoleController extends Controller
{
    public function __construct()
    {
        $this->setActiveMenu(self::MENU_ADMIN);

        parent::__construct();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $this->setActiveSubMenu(self::SUB_MENU_MANAGE_ROLE_PERMISSIONS);

        return response()->json(['roles' => Role::all()]);
    }

    public function togglePermission(SportToggleRequest $request): \Illuminate\Http\JsonResponse
    {
        Role::find($request->input('role'))->permissions()->toggle($request->input(['permission']));

        return response()->json(['success' => true]);
    }
}
