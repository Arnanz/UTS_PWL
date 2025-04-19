<script>
$(document).ready(function() {
    // Inisialisasi DataTables
    $('#tabel-transaksi').DataTable({
        "order": [[0, 'desc']]
    });

    // Format input jumlah (50.000)
    $('input[name="jumlah"]').on('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        value = new Intl.NumberFormat('id-ID').format(value);
        e.target.value = value;
    });
});
</script>