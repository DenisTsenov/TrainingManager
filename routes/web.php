<?php

use App\Http\Controllers\Auth\Admin\SettlementController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [LoginController::class, 'showLoginForm']);

Route::get('/login', [LoginController::class, 'showLoginForm'])
     ->name('login.show');

Route::get('/register', [RegisterController::class, 'create'])
     ->name('register.show')
     ->middleware('guest');

Route::middleware('ajax')->group(function () {
    Route::post('/store', [RegisterController::class, 'store'])
         ->name('register.store')
         ->middleware('guest');

    Route::post('/login', [LoginController::class, 'login'])
         ->name('login');

    Route::get('/settlements', [SettlementController::class, 'withSports'])
         ->name('settlements.with_sports');

    Route::get('/settlement/sports', [SettlementController::class, 'sports'])
         ->name('settlement.sports');
});

Route::namespace('Auth')
     ->middleware(['auth'])
     ->group(function () {
         require 'modules/auth.php';

         Route::namespace('Admin')
              ->middleware('admin')
              ->prefix('admin')
              ->group(fn() => Route::name('admin.')->group(fn() => require 'modules/admin.php'));
     });
