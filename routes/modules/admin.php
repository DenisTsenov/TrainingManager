<?php

use Illuminate\Support\Facades\Route;

/*
 * User Roles Routes
 */
Route::get('/manage-user-roles', 'ManageUserRoleController@index')
     ->name('admin.manage.user.roles');

Route::get('/find-user/{name}', 'ManageUserRoleController@findUser')
     ->name('admin.find.user');

Route::post('/change-role/{user}/{role}', 'ManageUserRoleController@changeRole')
     ->name('admin.change.role');

/*
 * Roles and Permissions Routes
 */
Route::view('/manage-role-permission', 'auth.admin.manage_role_permission')
     ->name('admin.manage.role.permission');

Route::get('/role/manage-role', 'ManageRoleController@index')
     ->name('admin.role.manage.role');

Route::get('/permission/manage-permission', 'ManagePermissionController@index')
     ->name('admin.permission.manage.permission');

Route::post('/role/assign-permission', 'ManageRoleController@togglePermission')
     ->name('admin.role.assign.permission');
