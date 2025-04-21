<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Mengembalikan instance class anonim (anonymous class) migration
return new class extends Migration
{
    /**
     * Method `up()` akan dijalankan saat menjalankan migrate:
     * php artisan migrate
     * Method ini bertugas membuat struktur tabel `transaksi`
     */
    public function up()
    {
        // Membuat tabel `transaksi` di dalam database
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id(); // Kolom primary key auto increment dengan nama `id`

            $table->date('tanggal'); 
            // Menyimpan tanggal transaksi, bertipe DATE (YYYY-MM-DD)

            $table->string('kategori', 20); 
            // Menyimpan jenis kategori transaksi: 'Pemasukan' atau 'Pengeluaran'
            // Panjang maksimal 20 karakter

            $table->string('deskripsi')->nullable(); 
            // Menyimpan keterangan/deskripsi transaksi
            // Kolom ini opsional (nullable)

            $table->decimal('jumlah', 15, 2); 
            // Menyimpan nominal uang transaksi
            // Maksimal 15 digit dengan 2 angka di belakang koma

            $table->timestamps(); 
            // Menambahkan kolom `created_at` dan `updated_at` secara otomatis
        });
    }

    /**
     * Method `down()` akan dijalankan saat rollback:
     * php artisan migrate:rollback
     * Bertugas menghapus tabel `transaksi` jika sebelumnya sudah dibuat
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
        // Menghapus tabel `transaksi` dari database jika ada
    }
};
