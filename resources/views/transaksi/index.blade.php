@extends('layouts.template')

@section('content')
<!-- Card utama untuk menampilkan data transaksi -->
<div class="card card-outline card-primary">
    <div class="card-header">
        <!-- Judul halaman, diambil dari variabel breadcrumb -->
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        
        <!-- Tombol untuk membuka modal tambah transaksi -->
        <div class="card-tools">
            <button type="button" class="btn btn-sm btn-primary" id="btnAddTransaksi">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </button>
        </div>
    </div>

    <div class="card-body">
        <!-- Menampilkan pesan sukses -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Menampilkan pesan error -->
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Card Rekap Keuangan -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="total-pemasukan">Rp 0</h3>
                        <p>Total Pemasukan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="total-pengeluaran">Rp 0</h3>
                        <p>Total Pengeluaran</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="saldo">Rp 0</h3>
                        <p>Saldo</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel data transaksi -->
        <table class="table table-bordered table-striped table-hover table-sm" id="table_transaksi">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal untuk menampung form (tambah/edit/delete) -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Konten modal akan dimuat via AJAX -->
        </div>
    </div>
</div>
@endsection


@push('js')
<script>
$(document).ready(function() {
    // Inisialisasi DataTable dengan server-side processing
    var dataTable = $('#table_transaksi').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: "{{ route('transaksi.list') }}", // URL untuk ambil data
            type: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}"; // CSRF token untuk keamanan
            }
        },
        columns: [
            { data: "tanggal", name: "tanggal" },
            { data: "kategori", name: "kategori" },
            { data: "deskripsi", name: "deskripsi" },
            { 
                data: "jumlah", 
                name: "jumlah",
                // Format kolom jumlah menjadi Rupiah
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            { 
                data: "aksi", 
                name: "aksi", 
                orderable: false, // Kolom aksi tidak bisa diurutkan
                searchable: false // Kolom aksi tidak bisa dicari
            }
        ],
        drawCallback: function() {
            updateRekapData(); // Update rekap setiap kali tabel dimuat ulang
        }
    });

    // Fungsi untuk memperbarui data rekap keuangan
    function updateRekapData() {
        $.ajax({
            url: "{{ route('transaksi.rekap') }}", // Buat route baru untuk rekap
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Format angka ke Rupiah
                var totalPemasukan = new Intl.NumberFormat('id-ID').format(response.total_pemasukan);
                var totalPengeluaran = new Intl.NumberFormat('id-ID').format(response.total_pengeluaran);
                var saldo = new Intl.NumberFormat('id-ID').format(response.saldo);
                
                // Update elemen HTML
                $('#total-pemasukan').text('Rp ' + totalPemasukan);
                $('#total-pengeluaran').text('Rp ' + totalPengeluaran);
                $('#saldo').text('Rp ' + saldo);
                
                // Ubah warna saldo berdasarkan nilainya
                if (response.saldo < 0) {
                    $('#saldo').parent().parent().removeClass('bg-info').addClass('bg-danger');
                } else {
                    $('#saldo').parent().parent().removeClass('bg-danger').addClass('bg-info');
                }
            },
            error: function(xhr) {
                console.error('Gagal memuat data rekap:', xhr);
            }
        });
    }

    // Panggil updateRekapData saat halaman dimuat
    updateRekapData();

    // Ketika tombol tambah transaksi diklik
    $('#btnAddTransaksi').on('click', function() {
        loadModal("{{ route('transaksi.create_ajax') }}"); // Load form tambah ke modal
    });

    // Menangani submit form dari modal (tambah/edit)
    $(document).on('submit', '#formTransaksi', function(e) {
        e.preventDefault(); // Mencegah reload halaman

        var form = $(this);
        var url = form.attr('action'); // URL dari action form
        var method = form.attr('method'); // Method dari form
        var data = form.serialize(); // Ambil data form dalam format urlencoded

        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide'); // Tutup modal
                    dataTable.ajax.reload(); // Reload tabel
                    updateRekapData(); // Update rekap setelah transaksi berhasil

                    // Tampilkan pesan sukses
                    toastr.success(response.message);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;

                // Tampilkan pesan error validasi di bawah field yang sesuai
                $.each(errors, function(key, value) {
                    $('#' + key + '_error').text(value[0]);
                });
            }
        });
    });

    // Ketika tombol edit diklik
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url'); // Ambil URL dari data-url
        loadModal(url); // Load form edit ke modal
    });

    // Ketika tombol delete diklik
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var url = "{{ route('transaksi.delete_ajax', ':id') }}".replace(':id', id);

        loadModal(url); // Load konfirmasi hapus
    });

    // Ketika tombol konfirmasi hapus diklik
    $(document).on('click', '#confirmDelete', function() {
        var id = $(this).data('id');

        $.ajax({
            url: "{{ route('transaksi.do_delete_ajax', ':id') }}".replace(':id', id),
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}" // Token CSRF
            },
            success: function(response) {
                $('#myModal').modal('hide'); // Tutup modal
                dataTable.ajax.reload(); // Reload tabel
                updateRekapData(); // Update rekap setelah transaksi dihapus
                toastr.success('Transaksi berhasil dihapus');
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan. Transaksi gagal dihapus');
            }
        });
    });
});

// Fungsi untuk load konten modal dari URL tertentu
function loadModal(url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            $('.modal-content').html(response); // Isi konten modal
            $('#myModal').modal('show'); // Tampilkan modal
        },
        error: function(xhr) {
            toastr.error('Terjadi kesalahan saat memuat modal');
        }
    });
}
</script>
@endpush