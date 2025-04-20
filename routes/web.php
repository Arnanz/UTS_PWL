<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

// Route Home
Route::get('/', [TransaksiController::class, 'index'])->name('home');

// AJAX Routes - Place these BEFORE the resource route
Route::prefix('transaksi')->group(function() {
    Route::post('/list', [TransaksiController::class, 'list'])->name('transaksi.list');
    Route::get('/create_ajax', [TransaksiController::class, 'create_ajax'])->name('transaksi.create_ajax');
    Route::post('/store_ajax', [TransaksiController::class, 'store_ajax'])->name('transaksi.store_ajax');
    Route::get('/{id}/edit_ajax', [TransaksiController::class, 'edit_ajax'])->name('transaksi.edit_ajax');
    Route::put('/{id}/update_ajax', [TransaksiController::class, 'update_ajax'])->name('transaksi.update_ajax');
    Route::get('/{id}/delete_ajax', [TransaksiController::class, 'confirm_ajax'])->name('transaksi.delete_ajax');
    Route::delete('/{id}/delete', [TransaksiController::class, 'delete_ajax'])->name('transaksi.do_delete_ajax');
});

// Resource routes - This should come AFTER the custom routes
Route::resource('transaksi', TransaksiController::class);