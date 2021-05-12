<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/welcome', [DashboardController::class, 'index'])
     ->name('welcome');

Route::get('/for-distribution', [DashboardController::class, 'forDistribution'])
     ->name('for-distribution');

Route::get('/profile/edit', [AuthController::class, 'edit'])
     ->name('profile.edit');

Route::post('/profile/{user}/update', [AuthController::class, 'update'])
     ->name('profile.update');

Route::post('/logout', [AuthController::class, 'logout'])
     ->name('logout');
