<?php

use Illuminate\Support\Facades\Route;

Route::get('/manage-roles', 'ManageRolesController@index')
     ->name('admin.manage.roles');

Route::get('/find-user/{name}', 'ManageRolesController@findUser')
     ->name('admin.find.user');

Route::post('/change-role/{user}/{role}', 'ManageRolesController@changeRole')
     ->name('admin.change.role');
