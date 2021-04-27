<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\ManageUserRoleController;
use App\Http\Controllers\Auth\Admin\ManageRoleController;
use App\Http\Controllers\Auth\Admin\ManagePermissionController;

/*
 * User Roles Routes
 */
Route::get('/manage-user-roles', [ManageUserRoleController::class, 'index'])
     ->name('admin.manage_user_roles');

Route::get('/find-user/{name}', [ManageUserRoleController::class, 'findUser'])
     ->name('admin.find_user');

Route::post('/change-role/{user}/{role}', [ManageUserRoleController::class, 'changeRole'])
     ->name('admin.change_role');

/*
 * Roles and Permissions Routes
 */
Route::view('/manage-role-permission', 'auth.admin.manage_role_permission')
     ->name('admin.manage_role_permission');

Route::get('/role/manage-role', [ManageRoleController::class, 'index'])
     ->name('admin.role.manage_role');

Route::get('/permission/manage-permission', [ManagePermissionController::class, 'index'])
     ->name('admin.permission.manage_permission');

Route::post('/role/toggle-permission', [ManageRoleController::class, 'togglePermission'])
     ->name('admin.role.toggle_permission');
