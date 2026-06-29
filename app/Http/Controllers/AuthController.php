<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;



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

    // TAMPIL REGISTER
    public function showRegister()
    {
        return view('auth', [
            'page' => 'register',
            'role' => 'user'
        ]);
    }

    // PROSES LOGIN USER
   public function login(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if ($user && $user->password == $request->password) {

        Auth::login($user);


        return redirect('/');
    }

    return back()->with('error', 'Email atau password salah');
}
    // PROSES REGISTER
    public function register(Request $request)
    {
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'user'
        ]);

        return redirect('/login')
            ->with('success', 'Registrasi berhasil');
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

public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->user();

    $user = User::firstOrCreate(
        ['email' => $googleUser->email],
        [
            'name' => $googleUser->name,
            'password' => '',
            'role' => 'user',
        ]
    );

    Auth::login($user);

    return redirect('/');
}


}