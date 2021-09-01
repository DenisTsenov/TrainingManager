<?php

use App\Http\Controllers\Auth\Admin\ManagePermissionController;
use App\Http\Controllers\Auth\Admin\ManageRoleController;
use App\Http\Controllers\Auth\Admin\ManageUserRoleController;
use App\Http\Controllers\Auth\Admin\SettlementController;
use App\Http\Controllers\Auth\Admin\SportController;
use App\Http\Controllers\Auth\AjaxController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\TeamController;
use Illuminate\Support\Facades\Route;

/*
 * User Roles Routes
 */
Route::get('/manage-user-roles', [ManageUserRoleController::class, 'index'])
     ->name('manage_user_roles');

Route::middleware('ajax')->group(function () {
    Route::get('/find-user/{name}', [ManageUserRoleController::class, 'findUser'])
         ->name('find_user');

    Route::post('/change-role/{user}/{role}', [ManageUserRoleController::class, 'changeRole'])
         ->name('change_role');
});

/*
 * Roles and Permissions Routes
 */
Route::view('/manage-role-permission', 'auth.admin.manage_role_permission')
     ->name('manage_role_permission');

Route::middleware('ajax')->group(function () {
    Route::get('/role/manage-role', [ManageRoleController::class, 'index'])
         ->name('role.manage_role');

    Route::get('/permission/manage-permission', [ManagePermissionController::class, 'index'])
         ->name('permission.manage_permission');

    Route::post('/role/toggle-permission', [ManageRoleController::class, 'togglePermission'])
         ->name('role.toggle_permission')
         ->middleware('ajax');
});

/*
 * Distribution users. Create teams
 */
Route::get('/team', [TeamController::class, 'index'])
     ->name('team');

Route::get('/team/list', [TeamController::class, 'list'])
     ->name('teams.list');

Route::get('/team/create', [TeamController::class, 'create'])
     ->name('team.create');

Route::post('/team/store', [TeamController::class, 'store'])
     ->name('team.store')
     ->middleware('ajax');

Route::get('/team/edit/{team}', [TeamController::class, 'edit'])
     ->name('team.edit');

Route::post('/team/update/{team}', [TeamController::class, 'update'])
     ->name('team.update')
     ->middleware('ajax');

Route::get('/for-distribution', [DashboardController::class, 'forDistribution'])
     ->name('for-distribution');

Route::get('/distribute-user/create/{user}', [DashboardController::class, 'createDistribution'])
     ->name('distribute.create');

Route::post('/distribute-user/store', [TeamController::class, 'storeDistribution'])
     ->name('distribute.store')
     ->middleware('ajax');

Route::get('/team/trainers', [AjaxController::class, 'getTrainers'])
     ->name('trainers')
     ->middleware('ajax');

Route::get('/sports/get', [AjaxController::class, 'getSports'])
     ->name('sports')
     ->middleware('ajax');

/*
 * Settlements and sports
 */
Route::get('/settlement', [SettlementController::class, 'index'])
     ->name('settlement');

Route::get('/settlement/list', [SettlementController::class, 'list'])
     ->name('settlement.list');

Route::get('/settlement/create', [SettlementController::class, 'create'])
     ->name('settlement.create');

Route::post('/settlement/store', [SettlementController::class, 'store'])
     ->name('settlement.store')
     ->middleware('ajax');

Route::get('/settlement/edit/{settlement}', [SettlementController::class, 'edit'])
     ->name('settlement.edit');

Route::post('/settlement/update/{settlement}', [SettlementController::class, 'update'])
     ->name('settlement.update')
     ->middleware('ajax');

Route::get('/sports', [SportController::class, 'index'])
     ->name('sport');

Route::get('/sport/list', [SportController::class, 'list'])
     ->name('sport.list');

Route::get('/sport/create', [SportController::class, 'create'])
     ->name('sport.create');

Route::post('/sport/store', [SportController::class, 'store'])
     ->name('sport.store')
     ->middleware('ajax');

Route::get('/sport/edit/{sport}', [SportController::class, 'edit'])
     ->name('sport.edit');

Route::post('/sport/update/{sport}', [SportController::class, 'update'])
     ->name('sport.update')
     ->middleware('ajax');

Route::post('/sport/toggle-activation/{sport}', [SportController::class, 'toggleActivation'])
     ->name('sport.toggle_activation')
     ->middleware('ajax');
