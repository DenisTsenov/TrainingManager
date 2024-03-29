<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Enums\Menu;

class LoginController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | Login Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles authenticating users for the application and
   | redirecting them to your home screen. The controller uses a trait
   | to conveniently provide its functionality to your applications.
   |
   */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/welcome';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->setActiveMenu(Menu::LOGIN->value);

        parent::__construct();
    }

    public function showLoginForm(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.login');
    }

    protected function sendLoginResponse(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return \response()->json(['route' => route('welcome')]);
    }
}
