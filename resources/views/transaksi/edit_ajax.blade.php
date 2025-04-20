<div class="modal-header">
    <h5 class="modal-title" id="modalLabel">Edit Transaksi</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="formTransaksi" action="{{ route('transaksi.update_ajax', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $transaksi->tanggal }}" required>
            <small id="tanggal_error" class="text-danger"></small>
        </div>
        
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select class="form-control" id="kategori" name="kategori" required>
                <option value="">Pilih Kategori</option>
                <option value="Pemasukan" {{ $transaksi->kategori == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="Pengeluaran" {{ $transaksi->kategori == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            <small id="kategori_error" class="text-danger"></small>
        </div>
        
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $transaksi->deskripsi }}</textarea>
            <small id="deskripsi_error" class="text-danger"></small>
        </div>
        
        <div class="form-group">
            <label for="jumlah">Jumlah (Rp)</label>
            <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ number_format($transaksi->jumlah, 0, ',', '.') }}" required>
            <small id="jumlah_error" class="text-danger"></small>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    // Format jumlah as currency
    $('#jumlah').on('keyup', function() {
        var value = $(this).val().replace(/\./g, '');
        if (value !== '') {
            value = parseInt(value);
            value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $(this).val(value);
        }
    });
});
</script>