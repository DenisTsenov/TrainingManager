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
     ->name('admin.manage_user_roles');

Route::middleware('ajax')->group(function () {
    Route::get('/find-user/{name}', [ManageUserRoleController::class, 'findUser'])
         ->name('admin.find_user');

    Route::post('/change-role/{user}/{role}', [ManageUserRoleController::class, 'changeRole'])
         ->name('admin.change_role');
});

/*
 * Roles and Permissions Routes
 */
Route::view('/manage-role-permission', 'auth.admin.manage_role_permission')
     ->name('admin.manage_role_permission');

Route::middleware('ajax')->group(function () {
    Route::get('/role/manage-role', [ManageRoleController::class, 'index'])
         ->name('admin.role.manage_role');

    Route::get('/permission/manage-permission', [ManagePermissionController::class, 'index'])
         ->name('admin.permission.manage_permission');

    Route::post('/role/toggle-permission', [ManageRoleController::class, 'togglePermission'])
         ->name('admin.role.toggle_permission')
         ->middleware('ajax');
});

/*
 * Distribution users. Create teams
 */
Route::get('/team', [TeamController::class, 'index'])
     ->name('admin.team');

Route::get('/team/list', [TeamController::class, 'list'])
     ->name('admin.teams.list');

Route::get('/team/create', [TeamController::class, 'create'])
     ->name('admin.team.create');

Route::post('/team/store', [TeamController::class, 'store'])
     ->name('admin.team.store')
     ->middleware('ajax');

Route::get('/team/edit/{team}', [TeamController::class, 'edit'])
     ->name('admin.team.edit');

Route::post('/team/update/{team}', [TeamController::class, 'update'])
     ->name('admin.team.update')
     ->middleware('ajax');

Route::get('/for-distribution', [DashboardController::class, 'forDistribution'])
     ->name('admin.for-distribution');

Route::get('/team/trainers', [AjaxController::class, 'getTrainers'])
     ->name('admin.trainers')
     ->middleware('ajax');

Route::get('/sports/get', [AjaxController::class, 'getSports'])
     ->name('admin.sports')
     ->middleware('ajax');

/*
 * Settlements and sports
 */
Route::get('/settlement', [SettlementController::class, 'index'])
     ->name('admin.settlement');

Route::get('/settlement/list', [SettlementController::class, 'list'])
     ->name('admin.settlement.list');

Route::get('/settlement/create', [SettlementController::class, 'create'])
     ->name('admin.settlement.create');

Route::post('/settlement/store', [SettlementController::class, 'store'])
     ->name('admin.settlement.store')
     ->middleware('ajax');

Route::get('/settlement/edit/{settlement}', [SettlementController::class, 'edit'])
     ->name('admin.settlement.edit');

Route::post('/settlement/update/{settlement}', [SettlementController::class, 'update'])
     ->name('admin.settlement.update')
     ->middleware('ajax');

Route::get('/sports', [SportController::class, 'index'])
     ->name('admin.sport');

Route::get('/sport/list', [SportController::class, 'list'])
     ->name('admin.sport.list');

Route::get('/sport/create', [SportController::class, 'create'])
     ->name('admin.sport.create');

Route::post('/sport/store', [SportController::class, 'store'])
     ->name('admin.sport.store')
     ->middleware('ajax');

Route::get('/sport/edit/{sport}', [SportController::class, 'edit'])
     ->name('admin.sport.edit');

Route::post('/sport/update/{sport}', [SportController::class, 'update'])
     ->name('admin.sport.update')
     ->middleware('ajax');

Route::post('/sport/toggle-disabled/{sport}', [SportController::class, 'toggleDisabled'])
     ->name('admin.sport.toggle_disabled')
     ->middleware('ajax');
