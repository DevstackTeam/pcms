<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate and authenticate the user...

        return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
    }

}
