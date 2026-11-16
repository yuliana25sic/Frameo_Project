<?php

use App\Http\Controllers\AuthController;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

// Halaman Utama (Katalog Paket Sementara)
Route::get('/', function () {
    $categories = Category::all();
    $packages = Package::with('category')->where('is_active', true)->get();
    return view('home', compact('categories', 'packages'));
})->name('home');

// Route Reservasi Customer (Harus Login)
Route::middleware('auth')->group(function () {
    Route::get('/booking/{package}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/booking', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/my-reservations/{reservation}/payment', [ReservationController::class, 'uploadPayment'])->name('reservations.uploadPayment');
});

// Route Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
