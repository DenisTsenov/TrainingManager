<?php

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

Route::namespace('Auth')->group(function () {
    Route::get('/', 'LoginController@showLoginForm');

    Route::get('/login', 'LoginController@showLoginForm')
         ->name('login.show');

    Route::get('/register', 'RegisterController@create')
         ->name('register.show');

    Route::post('/store', 'RegisterController@store')
         ->name('register.store');

    Route::post('/login', 'LoginController@login')
         ->name('login');

    Route::middleware(['auth'])->group(function () {
        Route::get('/welcome', function () {
            return view('home');
        })->name('welcome');

        Route::get('/profile', 'AuthController@edit')
             ->name('profile.edit');

        Route::post('/profile/{user}', 'AuthController@update')
             ->name('profile.update');

        Route::post('/logout', 'AuthController@logout')
             ->name('logout');
    });
});
