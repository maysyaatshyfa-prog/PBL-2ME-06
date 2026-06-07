<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomVariantController;

Route::get('/', [HomeController::class, 'index']);


// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

Route::get('/register', fn () => view('auth', [
    'page' => 'register',
    'role' => 'user'
]));

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// ROOM
Route::get('/rooms', [RoomVariantController::class, 'index'])->name('rooms.index');

Route::get('/rooms/{type}', [RoomController::class, 'type'])
    ->name('rooms.type');

Route::get('/room/{id}', [RoomController::class, 'show'])
    ->name('room.detail');


// BOOKING
Route::get('/booking/{id}', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('booking.create');

Route::post('/booking/confirm', [BookingController::class, 'confirm'])
    ->name('booking.confirm');

Route::get('/bookinghistory', [BookingController::class, 'index'])
    ->middleware('auth')
    ->name('bookinghistory.index');


// RESERVASI
Route::get('/reservasi/form', [ReservationController::class, 'form'])
    ->name('reservation.form');

Route::get('/reservasi', [ReservationController::class, 'index'])
    ->name('reservasi.index');

Route::get('/reservasi/konfirmasi', [ReservationController::class, 'konfirmasi'])
    ->name('reservasi.konfirmasi');

Route::post('/reservasi/assign/{id}', [ReservationController::class, 'assign'])
    ->name('reservasi.assign');


// PAYMENT
Route::get('/payment/success', [BookingController::class, 'success']);

Route::get('/payment/pending', [BookingController::class, 'payment'])
    ->name('payment.pending');

Route::get('/payment/{id}', [PaymentController::class, 'pay'])
    ->name('payment.pay');


// ADMIN
Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/admin/kelola_kamar', [AdminController::class, 'kelolaKamar'])
        ->name('admin.kelola_kamar');

    Route::get('/admin/pembayaran', [AdminController::class, 'pembayaran'])
        ->name('admin.pembayaran');

    Route::get('/admin/pembatalan', [AdminController::class, 'pembatalan'])
        ->name('admin.pembatalan');

    Route::post('/admin/pembayaran/acc/{id}', [AdminController::class, 'accPembayaran']);

    Route::post('/admin/pembatalan/acc/{id}', [AdminController::class, 'accPembatalan']);

    Route::post('/admin/pembatalan/tolak/{id}', [AdminController::class, 'tolakPembatalan']);
});