<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransaksiController;

// Route untuk CRUD Transaksi
Route::resource('transaksi', TransaksiController::class);

// Route Home
Route::get('/', [TransaksiController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('welcome');
});
