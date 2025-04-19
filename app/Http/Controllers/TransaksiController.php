<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    // Menampilkan semua transaksi (Read)
    public function index()
    {
        $transaksi = Transaksi::orderBy('tanggal', 'desc')->get();
        return view('transaksi.index', compact('transaksis'));
    }

    // Form tambah transaksi (Create)
    public function create()
    {
        $kategori = ['Pemasukan', 'Pengeluaran'];
        return view('transaksi.create', compact('kategori'));
    }

    // Simpan data transaksi (Store)
    public function store(Request $request)
    {
        // Konversi input jumlah (50.000 → 50000)
        $request->merge(['jumlah' => str_replace('.', '', $request->jumlah)]);

        // Validasi server-side
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric|min:0',
        ]);

        // Simpan ke database
        Transaksi::create($request->all());

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // Form edit transaksi (Edit)
    public function edit(Transaksi $transaksi)
    {
        $kategori = ['Pemasukan', 'Pengeluaran'];
        return view('transaksi.edit', compact('transaksi', 'kategori'));
    }

    // Update data transaksi (Update)
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->merge(['jumlah' => str_replace('.', '', $request->jumlah)]);

        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $transaksi->update($request->all());

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    // Hapus transaksi (Delete)
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}