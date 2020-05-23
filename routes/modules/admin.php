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
 * Role Permission Routes
 */
Route::get('/manage-role-permission', 'ManageRolePermissionController@index')
     ->name('admin.manage.role.permission');