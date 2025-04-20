<?php

namespace App\Http\Controllers;

use App\Models\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi',
            'list' => ['Home', 'Transaksi']
        ];

        return view('transaksi.index', compact('breadcrumb'));
    }

    public function list(Request $request)
    {
        $query = TransaksiModel::query();

        return DataTables::of($query)
            ->addColumn('aksi', function ($row) {
                $editBtn = '<button type="button" class="btn btn-sm btn-info btn-edit mr-1" data-url="' . route('transaksi.edit_ajax', $row->id) . '">
                        <i class="fas fa-edit"></i>
                      </button>';
                $deleteBtn = '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">
                        <i class="fas fa-trash"></i>
                      </button>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Fix the show method to actually return something instead of 404
    public function show(string $id)
    {
        $transaksi = TransaksiModel::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Detail Transaksi',
            'list' => ['Home', 'Transaksi', 'Detail']
        ];
        
        return view('transaksi.show', compact('transaksi', 'breadcrumb'));
    }

    public function create_ajax()
    {
        return view('transaksi.create_ajax');
    }

    public function store_ajax(Request $request)
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

        TransaksiModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Transaksi berhasil disimpan'
        ]);
    }
    
    public function edit_ajax(string $id)
    {
        $transaksi = TransaksiModel::find($id);
        return view('transaksi.edit_ajax', ['transaksi' => $transaksi]);
    }
    
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
    
    public function confirm_ajax(string $id)
    {
        $transaksi = TransaksiModel::find($id);
        return view('transaksi.confirm_ajax', ['transaksi' => $transaksi]);
    }
    
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
    
    // Add these standard resource controller methods
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi',
            'list' => ['Home', 'Transaksi', 'Tambah']
        ];
        
        return view('transaksi.create', compact('breadcrumb'));
    }
    
    public function store(Request $request)
    {
        // This method will handle the POST store_ajax route you defined
        return $this->store_ajax($request);
    }
    
    public function edit(string $id)
    {
        $transaksi = TransaksiModel::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Edit Transaksi',
            'list' => ['Home', 'Transaksi', 'Edit']
        ];
        
        return view('transaksi.edit', compact('transaksi', 'breadcrumb'));
    }
    
    public function update(Request $request, string $id)
    {
        return $this->update_ajax($request, $id);
    }
    
    public function destroy(string $id)
    {
        $transaksi = TransaksiModel::findOrFail($id);
        $transaksi->delete();
        
        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}