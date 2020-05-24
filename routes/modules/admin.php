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

Route::get('/manage-role', 'ManageRoleController@index')
     ->name('admin.manage.role');

Route::get('/manage-permission', 'ManagePermissionController@index')
     ->name('admin.manage.permission');
