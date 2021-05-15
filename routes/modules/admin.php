<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\ManageUserRoleController;
use App\Http\Controllers\Auth\Admin\ManageRoleController;
use App\Http\Controllers\Auth\Admin\ManagePermissionController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\TeamController;
use App\Http\Controllers\Auth\AjaxController;
use App\Http\Controllers\Auth\Admin\SettlementController;
use App\Http\Controllers\Auth\Admin\SportController;

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
         ->name('admin.role.toggle_permission');
});

/*
 * Distribution users. Create teams
 */
Route::get('/team', [TeamController::class, 'index'])
     ->name('admin.team');

Route::get('/teams-list', [TeamController::class, 'teamsList'])
     ->name('admin.teams_list');

Route::get('/team/create', [TeamController::class, 'create'])
     ->name('admin.team.create');

Route::post('/team/store', [TeamController::class, 'store'])
     ->middleware('ajax')
     ->name('admin.team.store');

Route::get('/team/edit/{team}', [TeamController::class, 'edit'])
     ->name('admin.team.edit');

Route::post('/team/update/{team}', [TeamController::class, 'update'])
     ->middleware('ajax')
     ->name('admin.team.update');

Route::get('/for-distribution', [DashboardController::class, 'forDistribution'])
     ->name('admin.for-distribution');

Route::get('/team/trainers', [AjaxController::class, 'getTrainers'])
     ->name('admin.trainers');

/*
 * Settlements and sports
 */
Route::get('/settlement/create', [SettlementController::class, 'create'])
     ->name('admin.settlement.create');

Route::post('/settlement/store', [SettlementController::class, 'store'])
     ->middleware('ajax')
     ->name('admin.settlement.store');

Route::get('/sport/create', [SportController::class, 'create'])
     ->name('admin.sport.create');

Route::post('/sport/store', [SportController::class, 'store'])
     ->middleware('ajax')
     ->name('admin.sport.store');
