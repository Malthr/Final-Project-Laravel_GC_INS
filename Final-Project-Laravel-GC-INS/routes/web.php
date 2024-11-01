<?php

use App\Http\Controllers\CastController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tables');
});

// Route::get('/', function () {
//     return view('layout.master');
// });