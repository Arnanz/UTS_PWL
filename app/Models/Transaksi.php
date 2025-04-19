<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (mass assignment).
     */
    protected $fillable = [
        'tanggal',
        'kategori',
        'deskripsi',
        'jumlah'
    ];

    /**
     * Kolom yang harus di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'tanggal' => 'date', // Cast kolom 'tanggal' ke tipe Carbon Date
        'jumlah' => 'decimal:2', // Cast kolom 'jumlah' ke tipe decimal dengan 2 digit desimal
    ];
}