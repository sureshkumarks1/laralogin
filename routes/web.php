<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Auth pages
Route::get('/', [AuthController::class, 'login'])->name('login');
// Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'loginPost']);

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('registeruser');

Route::get('/logout', [AuthController::class, 'logout']);

// Protected routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/admin', function () {
    return view('admin');
})->middleware('auth');

