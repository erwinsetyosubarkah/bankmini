const baseurl = document.getElementById('baseurl').value;
let dataTable;
const uang = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  });
window.addEventListener('load', function () {
    $(document).ready(function () {

        $('#btn-cekRekapPembayaranModal').on('click', function () {
            $('#modalCekRekapPembayaranLabel').html('Semua Rekap Pembayaran');
        });

        $('#btn-exportRekapPembayaranPerTanggalModal').on('click', function () {
            $('#modalExportRekapPembayaranPerTanggalLabel').html('Export Rekap Pembayaran Per Tanggal');
        });

   
        dataTable = $('#dataTable').DataTable({
            "language": {
                "url": baseurl + "assets/sbadmin/vendor/datatables/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "admin/rekap_pembayaran/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 7],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4, 5, 6, 7], "className": 'text-center' }]
        });
      


    });

});


