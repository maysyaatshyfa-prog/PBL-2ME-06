<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // TAMPIL LOGIN USER
    public function showLogin()
    {
        return view('auth', [
            'page' => 'login',
            'role' => 'user'
        ]);
    }

    // PROSES LOGIN USER
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->password == $request->password) {

            Auth::login($user);

            // kalau admin masuk dashboard
            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            // kalau user biasa ke home
            return redirect('/');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // TAMPIL LOGIN ADMIN
    public function showAdminLogin()
    {
        return view('auth', [
            'page' => 'login',
            'role' => 'admin'
        ]);
    }

    // PROSES LOGIN ADMIN
    public function adminLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->password == $request->password) {

            if ($user->role == 'admin') {

                Auth::login($user);

                return redirect('/admin/dashboard');
            }

            return back()->with('error', 'Akses ditolak, bukan admin');
        }

        return back()->with('error', 'Email atau password admin salah');
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}