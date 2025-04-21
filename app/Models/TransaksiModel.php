<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransaksiModel
 *
 * Model ini merepresentasikan tabel 'transaksi' dalam database.
 * Digunakan untuk mengelola data transaksi seperti tanggal, kategori, deskripsi, dan jumlah.
 */
class TransaksiModel extends Model
{
    // Trait HasFactory memungkinkan penggunaan factory untuk testing dan seeding
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'transaksi';

    /**
     * Primary key dari tabel 'transaksi'.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Kolom-kolom yang dapat diisi secara massal (mass assignment).
     * Kolom-kolom ini dapat diisi menggunakan metode seperti create() atau update().
     *
     * @var array
     */
    protected $fillable = [
        'tanggal',     // Tanggal transaksi
        'kategori',    // Kategori transaksi (misalnya: pengeluaran, pemasukan)
        'deskripsi',   // Deskripsi singkat mengenai transaksi
        'jumlah'       // Jumlah uang dalam transaksi
    ];
}
