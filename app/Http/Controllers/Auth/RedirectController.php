<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    function redirect_to_dashboard()
    {
        return redirect()->route('dashboard');
    }
}
