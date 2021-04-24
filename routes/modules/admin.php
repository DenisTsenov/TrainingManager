<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\ManageUserRoleController;
use App\Http\Controllers\Auth\Admin\ManageRoleController;
use App\Http\Controllers\Auth\Admin\ManagePermissionController;

/*
 * User Roles Routes
 */
Route::get('/manage-user-roles', [ManageUserRoleController::class, 'index'])
     ->name('admin.manage.user.roles');

Route::get('/find-user/{name}', [ManageUserRoleController::class, 'findUser'])
     ->name('admin.find.user');

Route::post('/change-role/{user}/{role}', [ManageUserRoleController::class, 'changeRole'])
     ->name('admin.change.role');

/*
 * Roles and Permissions Routes
 */
Route::view('/manage-role-permission', 'auth.admin.manage_role_permission')
     ->name('admin.manage.role.permission');

Route::get('/role/manage-role', [ManageRoleController::class, 'index'])
     ->name('admin.role.manage.role');

Route::get('/permission/manage-permission', [ManagePermissionController::class, 'index'])
     ->name('admin.permission.manage.permission');

Route::post('/role/assign-permission', [ManageRoleController::class, 'togglePermission'])
     ->name('admin.role.assign.permission');
