@empty($transaksi)
    <div class="alert alert-danger">Data tidak ditemukan!</div>
@else
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Transaksi</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-sm">
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $transaksi->tanggal }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $transaksi->kategori }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $transaksi->deskripsi ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
@endempty