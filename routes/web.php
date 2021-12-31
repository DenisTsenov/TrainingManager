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

         Route::get('test', function () {
             interface HasColor
             {
                 public function color(): string;
             }

             enum Menu: string implements HasColor
             {
                 case MENU_LOGIN = 'login';
                 case MENU_REGISTER = 'register';
                 case MENU_WELCOME = 'welcome';

                 case MENU_PROFILE = 'profile';
                 case SUB_MENU_EDIT_PROFILE = 'edit-profile';
                 case SUB_MENU_HISTORY = 'history';

                 case MENU_ADMIN = 'admin';
                 case SUB_MENU_MANAGE_USER_ROLES_PERMISSIONS = 'manage-user-roles';
                 case SUB_MENU_MANAGE_ROLE_PERMISSIONS = 'manage-role-permissions';
                 case SUB_MENU_TEAM = 'team';
                 case SUB_MENU_SETTLEMENTS = 'settlements';
                 case SUB_MENU_SETTLEMENTS_LIST = 'settlements-list';
                 case SUB_MENU_SETTLEMENT_CREATE_EDIT = 'settlement-create-edit';
                 case SUB_MENU_SPORTS = 'sports';
                 case SUB_MENU_SPORTS_LIST = 'sports-list';
                 case SUB_MENU_SPORT_CREATE_EDIT = 'sport-create-edit';

                 public function color(): string
                 {
                     return match ($this) {
                         self::MENU_LOGIN => 'green',
                         self::MENU_REGISTER => 'yellow',
                         self::MENU_WELCOME => 'brown',
                         self::MENU_PROFILE => 'blue',
                         self::SUB_MENU_EDIT_PROFILE => 'red',
                         self::SUB_MENU_HISTORY => 'gray',
                         self::MENU_ADMIN => 'silver',
                         self::SUB_MENU_MANAGE_USER_ROLES_PERMISSIONS => 'white',
                         self::SUB_MENU_MANAGE_ROLE_PERMISSIONS => 'magenta',
                         self::SUB_MENU_TEAM => 'bordo',
                         self::SUB_MENU_SETTLEMENTS => 'some',
                         self::SUB_MENU_SETTLEMENTS_LIST => 'some2',
                         self::SUB_MENU_SETTLEMENT_CREATE_EDIT => 'some3',
                         self::SUB_MENU_SPORTS => 'some4',
                         self::SUB_MENU_SPORTS_LIST => 'some5',
                         self::SUB_MENU_SPORT_CREATE_EDIT => 'some6',
                         default => 'no color',
                     };
                 }
             }

             dd(array_map(fn(Menu $menu) => $menu->color() . ' -> ' . $menu->value, Menu::cases()));
         });

         Route::namespace('Admin')
              ->middleware('admin')
              ->prefix('admin')
              ->group(fn() => Route::name('admin.')->group(fn() => require 'modules/admin.php'));
     });
