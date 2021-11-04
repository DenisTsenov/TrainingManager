<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $auth = Auth::user()->find(\auth()->id());

        if (Auth::user()->can('deactivateProfile', $auth)) {
            $destroyRoute = route('auth.destroy', [\auth()->id()]);
        }

        return view('auth.profile', [
            'user'         => $auth,
            'destroyRoute' => $destroyRoute ?? null,
        ]);
    }

    public function membershipHistory()
    {
        return view('auth.membershit_history', [
            'user' => User::with(['membershipHistory', 'sport', 'settlement'])->find(auth()->id()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RegisterRequest $request
     * @param User            $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RegisterRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        Auth::logout();
        session()->flash('logout', 'Profile disabled successfully!');

        return response()->json(['login' => route('login.show')]);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();

        session()->flash('logout', 'You have ben logged out successfully!');

        return response()->json(['route' => route('login.show')]);
    }
}
