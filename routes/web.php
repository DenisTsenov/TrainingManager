<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\Admin\SettlementController;

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
     ->name('register.show');

Route::post('/store', [RegisterController::class, 'store'])
     ->name('register.store');

Route::post('/login', [LoginController::class, 'login'])
     ->name('login');

Route::get('/settlements', [SettlementController::class, 'index'])
     ->middleware('ajax')
     ->name('settlements');

Route::get('/settlement/sports', [SettlementController::class, 'sports'])
     ->middleware('ajax')
     ->name('settlement.sports');

Route::namespace('Auth')
     ->middleware(['auth'])
     ->group(function () {
         require 'modules/auth.php';

         Route::namespace('Admin')
              ->middleware('admin')
              ->prefix('admin')
              ->group(function () {
                  require 'modules/admin.php';
              });
     });
