<?php

namespace App\Http\Controllers;

use App\Models\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Controller untuk mengelola data transaksi.
 * Menyediakan fitur CRUD dan integrasi dengan DataTables.
 */
class TransaksiController extends Controller
{
    /**
     * Menampilkan halaman daftar transaksi.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Breadcrumb untuk navigasi UI
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi',
            'list' => ['Home', 'Transaksi']
        ];

        return view('transaksi.index', compact('breadcrumb'));
    }

    /**
     * Mengambil data transaksi dalam format DataTables (untuk ajax).
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $query = TransaksiModel::query();

        return DataTables::of($query)
            ->addColumn('aksi', function ($row) {
                // Tombol Edit
                $editBtn = '<button type="button" class="btn btn-sm btn-info btn-edit mr-1" data-url="' . route('transaksi.edit_ajax', $row->id) . '">
                        <i class="fas fa-edit"></i>
                      </button>';
                // Tombol Hapus
                $deleteBtn = '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">
                        <i class="fas fa-trash"></i>
                      </button>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['aksi']) // Memastikan HTML ditampilkan apa adanya
            ->make(true);
    }

    /**
     * Menampilkan detail transaksi berdasarkan ID.
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $transaksi = TransaksiModel::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Detail Transaksi',
            'list' => ['Home', 'Transaksi', 'Detail']
        ];

        return view('transaksi.show', compact('transaksi', 'breadcrumb'));
    }

    /**
     * Menampilkan form tambah transaksi via ajax.
     * 
     * @return \Illuminate\View\View
     */
    public function create_ajax()
    {
        return view('transaksi.create_ajax');
    }

    /**
     * Menyimpan transaksi baru via ajax.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store_ajax(Request $request)
    {
        // Menghilangkan titik pemisah ribuan dari jumlah
        $request->merge(['jumlah' => str_replace('.', '', $request->jumlah)]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'kategori' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric|min:0',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan data transaksi
        TransaksiModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Transaksi berhasil disimpan'
        ]);
    }

    /**
     * Menampilkan form edit transaksi via ajax.
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit_ajax(string $id)
    {
        $transaksi = TransaksiModel::find($id);
        return view('transaksi.edit_ajax', ['transaksi' => $transaksi]);
    }

    /**
     * Memperbarui data transaksi via ajax.
     * 
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_ajax(Request $request, $id)
    {
        $request->merge(['jumlah' => str_replace('.', '', $request->jumlah)]);

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'kategori' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        TransaksiModel::find($id)->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Transaksi berhasil diperbarui'
        ]);
    }

    /**
     * Menampilkan konfirmasi sebelum menghapus transaksi via ajax.
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function confirm_ajax(string $id)
    {
        $transaksi = TransaksiModel::find($id);
        return view('transaksi.confirm_ajax', ['transaksi' => $transaksi]);
    }

    /**
     * Menghapus transaksi via ajax.
     * 
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_ajax(Request $request, $id)
    {
        $transaksi = TransaksiModel::find($id);
        if ($transaksi) {
            $transaksi->delete();
            return response()->json([
                'status' => true,
                'message' => 'Transaksi berhasil dihapus'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    /**
     * Menampilkan halaman form tambah transaksi (non-ajax).
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi',
            'list' => ['Home', 'Transaksi', 'Tambah']
        ];

        return view('transaksi.create', compact('breadcrumb'));
    }

    /**
     * Menyimpan transaksi (non-ajax), menggunakan logika ajax.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return $this->store_ajax($request);
    }

    /**
     * Menampilkan halaman edit transaksi (non-ajax).
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $transaksi = TransaksiModel::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Edit Transaksi',
            'list' => ['Home', 'Transaksi', 'Edit']
        ];

        return view('transaksi.edit', compact('transaksi', 'breadcrumb'));
    }

    /**
     * Memperbarui transaksi (non-ajax), menggunakan logika ajax.
     * 
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        return $this->update_ajax($request, $id);
    }

    /**
     * Menghapus transaksi secara langsung (non-ajax).
     * 
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $transaksi = TransaksiModel::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
    public function getRekapData()
{
    // Hitung total pemasukan (kategori 'Pemasukan')
    $totalPemasukan = TransaksiModel::where('kategori', 'Pemasukan')->sum('jumlah');
    
    // Hitung total pengeluaran (kategori 'Pengeluaran')
    $totalPengeluaran = TransaksiModel::where('kategori', 'Pengeluaran')->sum('jumlah');
    
    // Hitung saldo (selisih pemasukan dan pengeluaran)
    $saldo = $totalPemasukan - $totalPengeluaran;
    
    return response()->json([
        'total_pemasukan' => $totalPemasukan,
        'total_pengeluaran' => $totalPengeluaran,
        'saldo' => $saldo
    ]);
}
}
