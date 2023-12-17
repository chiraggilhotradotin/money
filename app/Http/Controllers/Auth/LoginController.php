<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    function login()
    {
        return view('login');
    }
    function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
    function google()
    {
        return Socialite::driver('google')->redirect();
    }
}
