<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\User;
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

        $userData = User::where('email', $request->email)->first();
        $userId = $userData ? $userData->id : null;

        if (Auth::attempt($data)) {
            if (!Auth::user()->is_active) {
                if ($userId) {
                    LoginHistory::create([
                        'user_id' => $userId,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'status' => 'failed'
                    ]);
                }

                Auth::logout();
                return back()->withErrors([
                    'error' => 'Akun dinonaktifkan.',
                ]);
            }

            LoginHistory::create([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'success'
            ]);

            return redirect()->intended('/');
        }

        if ($userId) {
            LoginHistory::create([
                'user_id' => $userId,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'failed'
            ]);
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
