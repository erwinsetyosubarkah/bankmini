const baseurl = document.getElementById('baseurl').value;
let dataTable;
const uang = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  });
window.addEventListener('load', function () {
    $(document).ready(function () {
        

        $('.js-example-basic-single').select2({
            theme:"bootstrap4"
        });

        $('#id_nasabah').change(function(){
            let id_nasabah = $(this).val();
            if(id_nasabah != ""){
                setFormCekSaldo(id_nasabah);
                cekSaldoNasabah(id_nasabah);                
            }else{
                clear();
            }
            //refresh table
            dataTable.ajax.reload();

            $("#btn-cetak").attr("href", "admin/cek_saldo_nasabah/cetak/"+id_nasabah);
            $("#btn-export").attr("href", "admin/cek_saldo_nasabah/export/"+id_nasabah);
        });

        $('#clearForm').on('click', function (){
            clear();
        });        

        getIdNasabah();

        dataTable = $('#dataTable').DataTable({
            "language": {
                "url": baseurl + "assets/sbadmin/vendor/datatables/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "admin/rekap_tabungan/queryAllByNasabah",
                method: "POST",
                data: function ( data ) {
                    data.id_nasabah = $('#id_nasabah').val();
                }
            },
            "columnDefs": [{
                "targets": [0, 7],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4, 5, 6, 7], "className": 'text-center' }]
        });

    });
});



function clear(){
    $('#id_nasabah').val("");  
    //refresh table
    dataTable.ajax.reload();
    getIdNasabah();
    $('#nama_nasabah').val("");           
    $('#saldo_nasabah').val("");           
    $('#transaksi_terakhir').val("");           
    $('#alamat_nasabah').val("");
    $('#no_tanda_pengenal_nasabah').val("");
    $('#kelas').val("");
    
}

function getIdNasabah() {

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/cek_saldo_nasabah/getIdNasabah',
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_nasabah').html(responsdata);
        }
    });
}



function setFormCekSaldo(id_nasabah){
    let data = new FormData();
    data.append('id_nasabah', id_nasabah);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/cek_saldo_nasabah/getNasabahById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_nasabah').val(responsdata.id_nasabah);
            $('#nama_nasabah').val(responsdata.nama_nasabah);           
            $('#alamat_nasabah').val(responsdata.alamat_nasabah);
            $('#no_tanda_pengenal_nasabah').val(responsdata.no_tanda_pengenal_nasabah);
            $('#kelas').val(responsdata.tingkat +' '+ responsdata.kode_jurusan + ' ' + responsdata.rombel);            
            
        }
    });
}

function cekSaldoNasabah(id_nasabah){
    let data = new FormData();
    data.append('id_nasabah', id_nasabah);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/cek_saldo_nasabah/getSaldoNasabah',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#saldo_nasabah').val(uang.format(responsdata));                     
            
        }
    });
}


