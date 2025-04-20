@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-sm btn-primary" id="btnAddTransaksi">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
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

<!-- Modal Container -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var dataTable = $('#table_transaksi').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: "{{ route('transaksi.list') }}",
            type: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}";
            }
        },
        columns: [
            { data: "tanggal", name: "tanggal" },
            { data: "kategori", name: "kategori" },
            { data: "deskripsi", name: "deskripsi" },
            { 
                data: "jumlah", 
                name: "jumlah",
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            { 
                data: "aksi", 
                name: "aksi", 
                orderable: false, 
                searchable: false 
            }
        ]
    });

    // Handle Add Transaction button click
    $('#btnAddTransaksi').on('click', function() {
        loadModal("{{ route('transaksi.create_ajax') }}");
    });

    // Handle modal events for form submission
    $(document).on('submit', '#formTransaksi', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var data = form.serialize();
        
        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    dataTable.ajax.reload();
                    
                    // Show success message
                    toastr.success(response.message);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                
                // Display validation errors
                $.each(errors, function(key, value) {
                    $('#' + key + '_error').text(value[0]);
                });
            }
        });
    });

    // Handle modal edit buttons
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        loadModal(url);
    });

    // Handle modal delete buttons
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var url = "{{ route('transaksi.delete_ajax', ':id') }}".replace(':id', id);
        
        loadModal(url); // Load confirmation modal
    });

    // Handle delete confirmation
    $(document).on('click', '#confirmDelete', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ route('transaksi.do_delete_ajax', ':id') }}".replace(':id', id),
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#myModal').modal('hide');
                dataTable.ajax.reload();
                toastr.success('Transaksi berhasil dihapus');
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan. Transaksi gagal dihapus');
            }
        });
    });
});

// Function to load modal content
function loadModal(url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            $('.modal-content').html(response);
            $('#myModal').modal('show');
        },
        error: function(xhr) {
            toastr.error('Terjadi kesalahan saat memuat modal');
        }
    });
}
</script>
@endpush