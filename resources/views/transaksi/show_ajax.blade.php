@empty($transaksi)
    <!-- Jika data transaksi tidak ditemukan, tampilkan alert -->
    <div class="alert alert-danger">Data tidak ditemukan!</div>
@else
<!-- Jika data transaksi tersedia, tampilkan detail dalam modal -->
<div class="modal-dialog">
    <div class="modal-content">

        <!-- Bagian header modal -->
        <div class="modal-header">
            <h5 class="modal-title">Detail Transaksi</h5>
            <!-- Tombol untuk menutup modal -->
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Bagian body modal yang menampilkan informasi transaksi -->
        <div class="modal-body">
            <table class="table table-sm">
                <!-- Baris tanggal transaksi -->
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $transaksi->tanggal }}</td>
                </tr>
                <!-- Baris kategori (Pemasukan / Pengeluaran) -->
                <tr>
                    <th>Kategori</th>
                    <td>{{ $transaksi->kategori }}</td>
                </tr>
                <!-- Baris jumlah transaksi dengan format mata uang rupiah -->
                <tr>
                    <th>Jumlah</th>
                    <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                </tr>
                <!-- Baris deskripsi transaksi; jika kosong ditampilkan tanda "-" -->
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $transaksi->deskripsi ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Bagian footer modal dengan tombol tutup -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
@endempty
