<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        // Data dummy manual
        $data = [
            [
                'tanggal' => '2024-03-01',
                'kategori' => 'Pemasukan',
                'deskripsi' => 'Gaji Bulanan',
                'jumlah' => 5000000,
                'created_at' => now(),
                'updated_at' => now()
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

        DB::table('transaksi')->insert($data);
    }
}