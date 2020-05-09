<?php

use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('home');
})->name('welcome');

Route::get('/profile/edit', 'AuthController@edit')
     ->name('profile.edit');

Route::post('/profile/{user}/update', 'AuthController@update')
     ->name('profile.update');

Route::post('/logout', 'AuthController@logout')
     ->name('logout');
