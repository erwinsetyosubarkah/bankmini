const baseurl = document.getElementById('baseurl').value;
let dataTable;
window.addEventListener('load', function () {
    $(document).ready(function () {

  

        dataTable = $('#dataTable').DataTable({
            "language": {
                "url": baseurl + "assets/sbadmin/vendor/datatables/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "admin/nasabah_tidak_aktif/getNasabahTidakAktif",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 6],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4, 5, 6], "className": 'text-center' }]
        });


    });
});





