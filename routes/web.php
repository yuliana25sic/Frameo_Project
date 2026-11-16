<?php

use App\Http\Controllers\AuthController;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Support\Facades\Route;

// Halaman Utama (Katalog Paket Sementara)
Route::get('/', function () {
    $categories = Category::all();
    $packages = Package::with('category')->where('is_active', true)->get();
    return view('home', compact('categories', 'packages'));
})->name('home');

// Route Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
