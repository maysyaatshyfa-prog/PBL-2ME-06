<?php

use Illuminate\Support\Facades\Route;
use App\htpp\Controller\HomeController;
use App\htpp\Controller\LoginController;
use App\htpp\Controller\RoomController;
use App\htpp\Controller\BookingController;
use App\htpp\Controller\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [LoginController::class, 'index']);

Route::get('/room', [RoomController::class, 'index']);
Route::get('/room{id}', [RoomController::class, 'detail']);

Route::get('/booking', [BookingController::class, 'index']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);