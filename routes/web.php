<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomVariantController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {

    $totalKamar = \App\Models\Room::count();
    $kamarTersedia = \App\Models\Room::count();

    $reservations = \App\Models\Reservation::with('user', 'room')
        ->latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalKamar',
        'kamarTersedia',
        'reservations'
    ));
})->middleware('auth')->name('dashboard');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware('auth');

// --- LOGIN USER/TAMU ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// --- LOGIN ADMIN ---
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// --- REGISTER & LOGOUT ---
Route::get('/register', fn () => view('auth', ['page' => 'register', 'role' => 'user']));
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// LIST KAMAR
Route::get('/rooms', [RoomVariantController::class, 'index'])->name('rooms.index');
// DETAIL KAMAR
Route::get('/rooms/{type}', [RoomController::class, 'type'])
    ->name('rooms.type');
    
Route::get('/booking/{id}', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('booking.create');
    
Route::post('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');

Route::get('/bookinghistory', [BookingController::class, 'index'])
    ->middleware('auth')
    ->name('bookinghistory.index');
    
Route::get('/reservasi/form', [ReservationController::class, 'form'])->name('reservation.form');
Route::get('/reservasi', [ReservationController::class, 'index'])
    ->name('reservasi.index');


Route::post('/reservasi/assign/{id}', [ReservationController::class, 'assign'])
    ->name('reservasi.assign');


Route::get('/room/{id}', [RoomController::class, 'show'])
    ->name('room.detail');


// --- KELOLA KAMAR ---
Route::get('/admin/kelola_kamar', [AdminController::class, 'kelolaKamar'])
    ->middleware('auth')
    ->name('admin.kelola_kamar');

// --- PEMBAYARAN TAMU  ---
Route::get('/payment/{id}', [BookingController::class, 'confirm'])->name('payment.page');
Route::post('/payment/confirm/{id}', [BookingController::class, 'storePayment'])->name('payment.store');
  // --- ROUTE UNTUK ADMIN PEMBAYARAN & PEMBATALAN ---
Route::middleware('auth')->group(function () {
    Route::get('/admin/pembayaran', [AdminController::class, 'pembayaran'])->name('admin.pembayaran');
    Route::get('/admin/pembatalan', [AdminController::class, 'pembatalan'])->name('admin.pembatalan');
    
    // Route untuk aksi tombol ACC dan Tolak
    Route::post('/admin/pembayaran/acc/{id}', [AdminController::class, 'accPembayaran']);
    Route::post('/admin/pembatalan/acc/{id}', [AdminController::class, 'accPembatalan']);
    Route::post('/admin/pembatalan/tolak/{id}', [AdminController::class, 'tolakPembatalan']);
}); 