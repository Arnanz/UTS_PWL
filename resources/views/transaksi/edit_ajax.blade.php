<!-- Modal Header -->
<div class="modal-header">
    <!-- Judul modal -->
    <h5 class="modal-title" id="modalLabel">Edit Transaksi</h5>

    <!-- Tombol untuk menutup modal -->
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Modal Body -->
<div class="modal-body">
    <!-- Form Edit Transaksi -->
    <!-- Menggunakan metode PUT untuk update data dan mengarahkan ke route transaksi.update_ajax -->
    <form id="formTransaksi" action="{{ route('transaksi.update_ajax', $transaksi->id) }}" method="POST">
        @csrf <!-- Token keamanan CSRF -->
        @method('PUT') <!-- Spoofing method agar form mendukung metode PUT -->

        <!-- Input: Tanggal transaksi -->
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <!-- Nilai default diambil dari data transaksi yang sedang diedit -->
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $transaksi->tanggal }}" required>
            <!-- Tempat muncul pesan validasi error untuk tanggal -->
            <small id="tanggal_error" class="text-danger"></small>
        </div>

        <!-- Select: Kategori transaksi -->
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select class="form-control" id="kategori" name="kategori" required>
                <option value="">Pilih Kategori</option>
                <!-- Pilihan otomatis terpilih sesuai data transaksi -->
                <option value="Pemasukan" {{ $transaksi->kategori == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="Pengeluaran" {{ $transaksi->kategori == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            <small id="kategori_error" class="text-danger"></small>
        </div>

        <!-- Textarea: Deskripsi transaksi -->
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $transaksi->deskripsi }}</textarea>
            <small id="deskripsi_error" class="text-danger"></small>
        </div>

        <!-- Input: Jumlah transaksi (dalam format rupiah) -->
        <div class="form-group">
            <label for="jumlah">Jumlah (Rp)</label>
            <!-- Nilai jumlah diformat dengan ribuan (.) -->
            <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ number_format($transaksi->jumlah, 0, ',', '.') }}" required>
            <small id="jumlah_error" class="text-danger"></small>
        </div>

        <!-- Modal Footer: Tombol aksi -->
        <div class="modal-footer">
            <!-- Tombol batal menutup modal tanpa menyimpan perubahan -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <!-- Tombol submit untuk menyimpan update -->
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

<!-- Script untuk memformat input jumlah ke dalam format Rupiah -->
<script>
$(document).ready(function() {
    // Saat user mengetik pada input jumlah
    $('#jumlah').on('keyup', function() {
        // Menghapus titik ribuan yang ada agar bisa diparse ke integer
        var value = $(this).val().replace(/\./g, '');

        if (value !== '') {
            // Konversi ke integer
            value = parseInt(value);

            // Format ulang dengan titik ribuan
            value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Update nilai input dengan format baru
            $(this).val(value);
        }
    });
});
</script>
