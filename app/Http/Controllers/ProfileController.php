<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048'
        ]);

        $path = $request->file('avatar')
                        ->store('avatars', 'public');

        $user = Auth::user();
        $user->avatar = $path;
        $user->save();

        return back()->with('success', 'Foto berhasil diubah');
    }
}