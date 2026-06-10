<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomVariantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

/* HOME */
Route::get('/', [HomeController::class, 'index']);

/* AUTH */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/* ROOM LIST (VARIANT FILTER) */
Route::get('/rooms', [RoomVariantController::class, 'index'])->name('rooms.index');

/* ROOM DETAIL */
Route::get('/room/{id}', [RoomVariantController::class, 'show'])->name('room.detail');

Route::get('/variant/{id}', [RoomVariantController::class, 'show'])
    ->name('variant.detail');

/* BOOKING */
Route::middleware('auth')->group(function () {
    Route::get('/booking/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::get('/booking/detail/{id}', [BookingController::class, 'show'])
    ->name('booking.detail');

    Route::get('/bookinghistory', [BookingController::class, 'index'])->name('bookinghistory.index');
    Route::post('/booking/cancel/{id}', [BookingController::class, 'cancel'])->name('booking.cancel');

     /* PROFILE */
    Route::view('/profile', 'profile')->name('profile');
    Route::post('/profile/avatar',
        [ProfileController::class, 'updateAvatar'])
        ->name('profile.avatar');
});

/* PAYMENT */
Route::get('/payment/success', [BookingController::class, 'success'])
    ->name('payment.success');
Route::get('/payment/{id}', [PaymentController::class, 'pay'])->name('payment.pay');


/* RESERVATION */
Route::get('/reservasi/form', [ReservationController::class, 'form'])->name('reservation.form');
Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
Route::post('/reservasi/assign/{id}', [ReservationController::class, 'assign'])->name('reservasi.assign');

/* ADMIN */
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/kelola_kamar', [AdminController::class, 'kelolaKamar']);
    Route::get('/pembayaran', [AdminController::class, 'pembayaran']);
    Route::get('/pembatalan', [AdminController::class, 'pembatalan']);
});