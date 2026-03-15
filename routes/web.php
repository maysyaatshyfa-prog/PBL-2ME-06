<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\HomeController;
use App\http\Controllers\LoginController;
use App\http\Controllers\RoomController;
use App\http\Controllers\BookingController;
use App\http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [LoginController::class, 'index']);

Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{id}', [RoomController::class, 'detail']);

Route::get('/booking', [BookingController::class, 'index']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);