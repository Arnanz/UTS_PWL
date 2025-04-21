<!-- Modal Header -->
<div class="modal-header">
    <!-- Judul modal -->
    <h5 class="modal-title" id="modalLabel">Tambah Transaksi</h5>

    <!-- Tombol untuk menutup modal -->
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Modal Body -->
<div class="modal-body">
    <!-- Form untuk menambahkan transaksi -->
    <!-- Menggunakan metode POST dan diarahkan ke route 'transaksi.store_ajax' -->
    <form id="formTransaksi" action="{{ route('transaksi.store_ajax') }}" method="POST">
        @csrf <!-- Token CSRF untuk keamanan pengiriman data -->

        <!-- Input: Tanggal transaksi -->
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            <!-- Tempat munculnya pesan error validasi -->
            <small id="tanggal_error" class="text-danger"></small>
        </div>

        <!-- Select: Kategori transaksi -->
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select class="form-control" id="kategori" name="kategori" required>
                <option value="">Pilih Kategori</option>
                <option value="Pemasukan">Pemasukan</option>
                <option value="Pengeluaran">Pengeluaran</option>
            </select>
            <small id="kategori_error" class="text-danger"></small>
        </div>

        <!-- Textarea: Deskripsi tambahan (opsional) -->
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            <small id="deskripsi_error" class="text-danger"></small>
        </div>

        <!-- Input: Jumlah uang transaksi -->
        <div class="form-group">
            <label for="jumlah">Jumlah (Rp)</label>
            <input type="text" class="form-control" id="jumlah" name="jumlah" required>
            <small id="jumlah_error" class="text-danger"></small>
        </div>

        <!-- Tombol aksi -->
        <div class="modal-footer">
            <!-- Batal menutup modal -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <!-- Submit form untuk menyimpan transaksi -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<!-- Script jQuery untuk memformat input jumlah sebagai angka rupiah -->
<script>
$(document).ready(function() {
    // Saat user mengetik di field jumlah
    $('#jumlah').on('keyup', function() {
        // Ambil nilai input dan hilangkan titik ribuan
        var value = $(this).val().replace(/\./g, '');

        if (value !== '') {
            // Ubah ke integer
            value = parseInt(value);

            // Format ke bentuk rupiah dengan titik setiap 3 digit
            value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Tampilkan kembali hasil yang sudah diformat
            $(this).val(value);
        }
    });
});
</script>
