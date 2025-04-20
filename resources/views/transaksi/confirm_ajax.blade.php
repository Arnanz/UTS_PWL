<div class="modal-header">
    <h5 class="modal-title" id="modalLabel">Konfirmasi Hapus</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
    <table class="table table-bordered">
        <tr>
            <th>Tanggal</th>
            <td>{{ $transaksi->tanggal }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $transaksi->kategori }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $transaksi->deskripsi }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-danger" id="confirmDelete" data-id="{{ $transaksi->id }}">Hapus</button>
</div>