<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    public function forgotPassword()
    {
        return view('authentication/forgotPassword');
    }


    public function actionSignIn(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($data)) {

            return redirect()->intended('/');
        }


        return back()->withErrors([
            'error' => 'These credentials do not match our records.',
        ]);
    }

    public function signin()
    {
        return view('authentication/signin');
    }

    public function signup()
    {
        return view('authentication/signup');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
