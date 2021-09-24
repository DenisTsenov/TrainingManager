<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::view('/welcome', 'home')->name('welcome');

Route::get('/profile/edit', [AuthController::class, 'edit'])
     ->name('profile.edit');

Route::get('/profile/membership-history', [AuthController::class, 'membershipHistory'])
     ->name('profile.membership_history');

Route::middleware('ajax')->group(function () {
    Route::put('/profile/{user}/update', [AuthController::class, 'update'])
         ->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])
         ->name('logout');
});
