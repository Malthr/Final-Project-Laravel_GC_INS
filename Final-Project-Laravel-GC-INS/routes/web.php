<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReplyController;
use App\Models\User;

Route::get('/', function () {
    return view('auth.auth'); // Menunjuk ke folder auth jika login ada di situ
});

Route::get('/home',[PostController::class,'index'])->middleware(['auth'])->name('homepage');

// Route::get('/table', function () {
//     // $profile = User::where('id', $id)->first;
//     return view('tables');
// })->middleware(['auth', 'verified'])->name('table');

// Rute untuk pendaftaran

// Rute untuk tampilan login dan registrasi
Route::get('/auth', function () {
    return view('auth'); // Pastikan mengarah ke file auth.blade.php
})->name('auth');

// Rute untuk registrasi
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rute untuk login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Rute untuk posting
Route::get('/post-create', [PostController::class, 'create'])->name('post.create');
Route::post('/post-create', [PostController::class, 'store'])->name('post.store');

//Rute untuk komentar
Route::post('/replys/store', [ReplyController::class, 'store'])->name('replys.store');  

Route::get('/search', [PostController::class, 'search'])->name('search');





// Rute untuk profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
