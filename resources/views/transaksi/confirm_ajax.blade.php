<!-- Modal Header -->
<div class="modal-header">
    <!-- Judul Modal -->
    <h5 class="modal-title" id="modalLabel">Konfirmasi Hapus</h5>

    <!-- Tombol untuk menutup modal -->
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Modal Body -->
<div class="modal-body">
    <!-- Pesan konfirmasi untuk pengguna -->
    <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>

    <!-- Tabel ringkasan data transaksi yang akan dihapus -->
    <table class="table table-bordered">
        <tr>
            <!-- Tanggal transaksi -->
            <th>Tanggal</th>
            <td>{{ $transaksi->tanggal }}</td>
        </tr>
        <tr>
            <!-- Kategori transaksi: Pemasukan atau Pengeluaran -->
            <th>Kategori</th>
            <td>{{ $transaksi->kategori }}</td>
        </tr>
        <tr>
            <!-- Deskripsi transaksi (jika ada) -->
            <th>Deskripsi</th>
            <td>{{ $transaksi->deskripsi }}</td>
        </tr>
        <tr>
            <!-- Jumlah transaksi yang diformat dalam rupiah -->
            <th>Jumlah</th>
            <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>

<!-- Modal Footer -->
<div class="modal-footer">
    <!-- Tombol untuk membatalkan penghapusan -->
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

    <!-- Tombol untuk mengonfirmasi penghapusan -->
    <!-- data-id digunakan untuk mengirim ID transaksi ke script JavaScript -->
    <button type="button" class="btn btn-danger" id="confirmDelete" data-id="{{ $transaksi->id }}">Hapus</button>
</div>
