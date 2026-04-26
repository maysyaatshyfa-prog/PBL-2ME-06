<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Models\Reservation;
use App\Http\Controllers\ReservationController;
use App\Models\Room;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/app', function () {
return view('app');
});
Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/dashboard', function () {

    $totalKamar = Room::count();
    $kamarTersedia = Room::count();

    $reservations = Reservation::with('user','room')
                    ->latest()
                    ->take(5)
                    ->get();

    return view('admin.dashboard', compact(
        'totalKamar',
        'kamarTersedia',
        'reservations'
    ));

})->name('dashboard');


// =====================
// KELOLA KAMAR
// =====================
Route::resource('rooms', RoomController::class);


// =====================
// RESERVASI ADMIN
// =====================

Route::get('/', [HomeController::class, 'index']);
Route::get('/login', fn() => view('auth', ['page' => 'login']));
Route::get('/register', fn() => view('auth', ['page' => 'register']));
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{id}', [RoomController::class, 'detail']);

Route::get('/booking/{id}', [BookingController::class, 'create'])
    ->middleware('auth');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::view('/tugas', 'tugas');

Route::get('/reservasi', [ReservationController::class, 'index'])
    ->name('reservasi.index');

Route::post('/reservasi', [ReservationController::class, 'store'])
    ->name('reservasi.store');

// assign kamar (opsional bagus)
Route::post('/reservasi/assign/{id}', [ReservationController::class, 'assign'])
     ->name('reservasi.assign');

Route::get('/bookinghistory', [BookingController::class, 'index'])
    ->name('bookinghistory.index');
