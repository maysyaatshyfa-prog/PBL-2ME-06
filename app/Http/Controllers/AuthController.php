<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->password == $request->password) {
            Auth::login($user);
            return redirect('/');
        }

        return back()->with('error', 'Email atau password salah');
    }
    public function dashboard()
    {
        return view('bookinghistory');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}