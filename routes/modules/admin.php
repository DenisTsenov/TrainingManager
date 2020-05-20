<?php

use Illuminate\Support\Facades\Route;

Route::get('/manage-roles', 'ManageRolesController@index')
     ->name('admin.manage.roles');

Route::get('/find-user/{name}', 'ManageRolesController@find');
