<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cancellation;

class CancellationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required',
            'reason' => 'required'
        ]);

        Cancellation::create([
            'reservation_id' => $request->reservation_id,
            'user_id'        => Auth::id(),
            'alasan'         => $request->reason,
            'status'         => 'Menunggu'
        ]);

        return back()->with(
            'success',
            'Permohonan pembatalan berhasil dikirim.'
        );
    }
}