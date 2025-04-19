@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Transaksi</h3>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary float-right">Tambah Transaksi</a>
    </div>
    <div class="card-body">
        <table id="tabel-transaksi" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->tanggal }}</td>
                    <td>{{ $transaksi->kategori }}</td>
                    <td>{{ $transaksi->deskripsi ?? '-' }}</td>
                    <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection