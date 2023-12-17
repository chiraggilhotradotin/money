<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    function google(Request $request)
    {
        $google_user = Socialite::driver('google')->user();
        $user = User::where('email', $google_user['email'])->first();
        if (!$user) {
            $user = new User();
            $user->google_id = $google_user['id'];
            $user->name = $google_user['name'];
            $user->email =  $google_user['email'];
            $user->image =  $google_user['picture'];
            do {
                $uuid = Str::orderedUuid();
                $user->uuid = $uuid;
            } while (User::where('uuid', $uuid)->count() != 0);
            $user->save();
        }
        auth()->loginUsingId($user->id, true);
        return redirect()->route('redirect_to_dashboard');
    }
}
