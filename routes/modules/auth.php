<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::view('/welcome', 'home', ['activeMenu' => 'welcome', 'activeSubMenu' => collect()])->name('welcome');

Route::get('/profile/edit', [AuthController::class, 'edit'])
     ->name('profile.edit');

Route::get('/profile/history-membership', [AuthController::class, 'historyMembership'])
     ->name('profile.history_membership');

Route::middleware('ajax')->group(function () {
    Route::put('/profile/{user}/update', [AuthController::class, 'update'])
         ->name('profile.update');

    Route::post('/profile/destroy/{user}', [AuthController::class, 'destroy'])
         ->name('auth.destroy')
         ->middleware(['can:deactivateProfile,user']);

    Route::post('/logout', [AuthController::class, 'logout'])
         ->name('logout');
});
