<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('auth.auth'); // Menunjuk ke folder auth jika login ada di situ
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute untuk pendaftaran

// Rute untuk tampilan login dan registrasi
Route::get('/auth', function () {
    return view('auth'); // Pastikan mengarah ke file auth.blade.php
})->name('auth');

// Rute untuk registrasi
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rute untuk login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


// Rute untuk profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
