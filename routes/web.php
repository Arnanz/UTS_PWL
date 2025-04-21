<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| File ini mendefinisikan semua rute HTTP untuk aplikasi web.
| Diatur menggunakan Laravel Routing System.
*/

// Route Home - menampilkan halaman utama dengan daftar transaksi
Route::get('/', [TransaksiController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| AJAX Routes untuk Transaksi
|--------------------------------------------------------------------------
| Rute-rute ini digunakan untuk memproses request AJAX tanpa refresh halaman.
| Diletakkan sebelum resource route agar tidak tertimpa oleh route default.
*/
Route::prefix('transaksi')->group(function() {

    // Mengambil data transaksi dalam format DataTables
    Route::post('/list', [TransaksiController::class, 'list'])->name('transaksi.list');

    // Menampilkan form tambah transaksi (modal)
    Route::get('/create_ajax', [TransaksiController::class, 'create_ajax'])->name('transaksi.create_ajax');

    // Menyimpan data transaksi baru dari form AJAX
    Route::post('/store_ajax', [TransaksiController::class, 'store_ajax'])->name('transaksi.store_ajax');

    // Menampilkan form edit transaksi berdasarkan ID (modal)
    Route::get('/{id}/edit_ajax', [TransaksiController::class, 'edit_ajax'])->name('transaksi.edit_ajax');

    // Mengupdate data transaksi berdasarkan ID melalui AJAX
    Route::put('/{id}/update_ajax', [TransaksiController::class, 'update_ajax'])->name('transaksi.update_ajax');

    // Menampilkan konfirmasi hapus transaksi (modal)
    Route::get('/{id}/delete_ajax', [TransaksiController::class, 'confirm_ajax'])->name('transaksi.delete_ajax');

    // Mengeksekusi penghapusan transaksi berdasarkan ID
    Route::delete('/{id}/delete', [TransaksiController::class, 'delete_ajax'])->name('transaksi.do_delete_ajax');

    // Route baru untuk mengambil data rekap transaksi
    Route::get('/rekap', [TransaksiController::class, 'getRekapData'])->name('transaksi.rekap');
});

/*
|--------------------------------------------------------------------------
| Resource Route untuk Transaksi
|--------------------------------------------------------------------------
| Mendefinisikan semua route resource standar Laravel untuk controller
| seperti index, create, store, show, edit, update, destroy.
| Diletakkan terakhir agar tidak menimpa custom route di atas.
*/
Route::resource('transaksi', TransaksiController::class);
