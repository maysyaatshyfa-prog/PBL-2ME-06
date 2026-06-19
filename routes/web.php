<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomVariantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CancellationController;
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

Route::get('/rooms/{id}', [RoomVariantController::class, 'show'])->name('rooms.show');

Route::get('/rooms/type/{type}', function ($type) {
    return view('rooms.type', compact('type'));
});

/* BOOKING */
Route::middleware('auth')->group(function () {
    Route::get('/booking/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::get('/booking/detail/{id}', [BookingController::class, 'show'])
    ->name('booking.detail');

    Route::get('/bookinghistory', [BookingController::class, 'index'])->name('bookinghistory.index');
    Route::post('/cancellation/store', [CancellationController::class, 'store']) ->name('cancellation.store');

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
Route::get('/payment/pending', [BookingController::class, 'payment'])->name('payment.pending');


/* RESERVATION */
Route::get('/reservasi/form', [ReservationController::class, 'form'])->name('reservation.form');
Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
Route::post('/reservasi/assign/{id}', [ReservationController::class, 'assign'])->name('reservasi.assign');

/* ADMIN */
Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/kelola_kamar', [AdminController::class, 'kelolaKamar'])
    ->name('admin.kelola-kamar');
    Route::get('/kamar/{id}', [AdminController::class, 'daftarKamar'])
        ->name('admin.kamar.detail');

    Route::post(
    '/kamar/tambah',
    [AdminController::class, 'tambahKamar']
)->name('admin.kamar.tambah');

    // Reservasi Admin
    Route::get('/reservasi', [AdminController::class, 'reservasiIndex'])
        ->name('admin.reservasi.index');

    Route::patch('/reservasi/{id}/update-status',
        [AdminController::class, 'updateReservasiStatus'])
        ->name('admin.reservasi.updateStatus');

    // Pembayaran
    Route::get('/pembayaran', [AdminController::class, 'pembayaran'])
        ->name('admin.pembayaran');

    Route::post('/pembayaran/acc/{id}',
        [AdminController::class, 'accPembayaran'])
        ->name('admin.pembayaran.acc');

    // Pembatalan
    Route::get('/pembatalan', [AdminController::class, 'pembatalan'])
        ->name('admin.pembatalan');

    Route::post('/pembatalan/acc/{id}',
        [AdminController::class, 'accPembatalan'])
        ->name('admin.pembatalan.acc');

    Route::post('/pembatalan/tolak/{id}',
        [AdminController::class, 'tolakPembatalan'])
        ->name('admin.pembatalan.tolak');

        Route::get('/kelola-kamar/{id}/edit', [AdminController::class, 'edit'])
    ->name('admin.kelola-kamar.edit');

Route::put('/kelola-kamar/{id}', [AdminController::class, 'update'])
    ->name('admin.kelola-kamar.update');
});