const baseurl = document.getElementById('baseurl').value;
let dataTable;
const uang = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  });
window.addEventListener('load', function () {
    $(document).ready(function () {

        $('#btn-cekRekapTabunganModal').on('click', function () {
            $('#modalCekRekapTabunganLabel').html('Semua Rekap Tabungan');
        });

        $('#btn-exportRekapTabunganPerTanggalModal').on('click', function () {
            $('#modalExportRekapTabunganPerTanggalLabel').html('Export Rekap Tabungan Per Tanggal');
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
                url: "admin/rekap_tabungan/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 7],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4, 5, 6, 7], "className": 'text-center' }]
        });
      


    });

});


