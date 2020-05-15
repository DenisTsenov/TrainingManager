<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Role;
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
     * @param Request $requser
     */
    public function getUser(Request $requser)
    {

    }
}
