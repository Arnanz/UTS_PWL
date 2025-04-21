<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Method ini akan dijalankan saat kita menjalankan:
     * php artisan db:seed --class=TransaksiSeeder
     */
    public function run()
    {
        // Data dummy manual yang akan dimasukkan ke tabel `transaksi`
        $data = [
            [
                'tanggal' => '2024-03-01',             // Tanggal transaksi
                'kategori' => 'Pemasukan',             // Kategori: Pemasukan
                'deskripsi' => 'Gaji Bulanan',         // Keterangan transaksi
                'jumlah' => 5000000,                   // Jumlah nominal (dalam rupiah)
                'created_at' => now(),                 // Timestamp kapan dibuat
                'updated_at' => now()                  // Timestamp kapan diupdate
            ],
            [
                'tanggal' => '2024-03-05',
                'kategori' => 'Pengeluaran',
                'deskripsi' => 'Belanja Bulanan',
                'jumlah' => 750000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tanggal' => '2024-03-10',
                'kategori' => 'Pengeluaran',
                'deskripsi' => 'Bayar Listrik',
                'jumlah' => 250000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Menyisipkan data ke tabel `transaksi` menggunakan query builder
        DB::table('transaksi')->insert($data);
    }
}
