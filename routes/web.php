<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomVariantController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| AUTH USER
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth', ['page' => 'register', 'role' => 'user']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTH ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

/*
|--------------------------------------------------------------------------
| KAMAR
|--------------------------------------------------------------------------
*/
Route::get('/rooms', [RoomVariantController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{type}', [RoomController::class, 'type'])->name('rooms.type');
Route::get('/room/{id}', [RoomController::class, 'show'])->name('room.detail');

/*
|--------------------------------------------------------------------------
| BOOKING (Diperbaiki: Pemisahan Create & Detail)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Form buat booking baru
    Route::get('/booking/detail/{id}', [BookingController::class, 'show'])
        ->name('booking.create');

    // Rute untuk melihat Detail/Nota (Menghindari layar putih)
    Route::get('/booking/detail/{id}', [BookingController::class, 'show'])
        ->name('booking.show');

    Route::post('/booking/confirm', [BookingController::class, 'confirm'])
        ->name('booking.confirm');

    Route::get('/bookinghistory', [BookingController::class, 'index'])
        ->name('bookinghistory.index');
        
    // Rute Pembatalan
    Route::post('/booking/cancel/{id}', [BookingController::class, 'cancel'])
        ->name('booking.cancel');
});

/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/
Route::get('/payment/{id}', [BookingController::class, 'confirm'])
    ->name('payment.page');

Route::post('/payment/confirm/{id}', [BookingController::class, 'storePayment'])
    ->name('payment.store');

/*
|--------------------------------------------------------------------------
| RESERVASI (Sisi User / Tamu)
|--------------------------------------------------------------------------
*/
Route::get('/reservasi/form', [ReservationController::class, 'form'])->name('reservation.form');
Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
Route::post('/reservasi/assign/{id}', [ReservationController::class, 'assign'])->name('reservasi.assign');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/kelola_kamar', [AdminController::class, 'kelolaKamar'])->name('admin.kelola_kamar');

    // Reservasi Admin
    Route::get('/reservasi', [AdminController::class, 'reservasiIndex'])->name('admin.reservasi.index');
    Route::patch('/reservasi/{id}/update-status', [AdminController::class, 'updateReservasiStatus'])->name('admin.reservasi.updateStatus');

    // Pembayaran
    Route::get('/pembayaran', [AdminController::class, 'pembayaran'])->name('admin.pembayaran');
    Route::post('/pembayaran/acc/{id}', [AdminController::class, 'accPembayaran'])->name('admin.pembayaran.acc');

    // Pembatalan
    Route::get('/pembatalan', [AdminController::class, 'pembatalan'])->name('admin.pembatalan');
    Route::post('/pembatalan/acc/{id}', [AdminController::class, 'accPembatalan'])->name('admin.pembatalan.acc');
    Route::post('/pembatalan/tolak/{id}', [AdminController::class, 'tolakPembatalan'])->name('admin.pembatalan.tolak');
});