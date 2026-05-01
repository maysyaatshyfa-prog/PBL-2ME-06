<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // MENAMPILKAN LOGIN USER 
    public function showLogin()
    {
        return view('auth', ['page' => 'login', 'role' => 'user']);
    }

    // PROSES LOGIN USER
    public function login(Request $request)
    {
        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if ($user && $user->password === $request->password) {
            Auth::login($user); 

            if ($user->role === 'user') {
                return redirect('/');
            }
            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // MENAMPILKAN LOGIN ADMIN 
    public function showAdminLogin()
    {
        return view('auth', ['page' => 'login', 'role' => 'admin']);
    }

    // PROSES LOGIN ADMIN
    public function adminLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->password === $request->password) {
            if ($user->role === 'admin') {
                Auth::login($user);
                return redirect('/admin/dashboard');
            }

            Auth::logout();
            return back()->with('error', 'Akses Ditolak: Anda bukan Admin');
        }

        return back()->with('error', 'Email atau password admin salah');
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