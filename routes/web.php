<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;


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
})->name('dashboard');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

Route::get('/login', fn () => view('auth', ['page' => 'login']));
Route::get('/register', fn () => view('auth', ['page' => 'register']));
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/logout', [AuthController::class, 'logout']);

// LIST KAMAR
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

// DETAIL KAMAR
Route::get('/rooms/{type}', [RoomController::class, 'type'])
    ->name('rooms.type');
    
Route::get('/booking/{id}', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('booking.create');

Route::get('/bookinghistory', [BookingController::class, 'index'])
    ->name('bookinghistory.index');


Route::get('/reservasi', [ReservationController::class, 'index'])
    ->name('reservasi.index');

Route::post('/reservasi', [ReservationController::class, 'store'])
    ->name('reservasi.store');

Route::post('/reservasi/assign/{id}', [ReservationController::class, 'assign'])
    ->name('reservasi.assign');


Route::view('/tugas', 'tugas');