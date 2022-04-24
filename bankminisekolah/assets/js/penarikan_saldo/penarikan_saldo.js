const baseurl = document.getElementById('baseurl').value;
let dataTable;
const uang = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  });
window.addEventListener('load', function () {
    $(document).ready(function () {



        $('#btn-tambahModal').on('click', function () {
            $('#modalPenarikanSaldoLabel').html('Tambah Penarikan Saldo');
            $('#btn-modalPenarikanSaldo').html('Tambah');
            cekId();
            cekSaldoBankmini();

        });
        
        $('#btn-cekHariIniModal').on('click', function () {
            $('#modalCekHariIniLabel').html('Cek Hari Ini');
        });

        $('#btn-cekSemuaPenarikanModal').on('click', function () {
            $('#modalCekSemuaPenarikanLabel').html('Cek Semua Penarikan');
        });

        $('#btn-exportPenarikanSaldoPerTanggalModal').on('click', function () {
            $('#modalExportPenarikanSaldoPerTanggalLabel').html('Export Penarikan Saldo Per Tanggal');
        });

        
        $('#btn-modalPenarikanSaldo').on('click', function (e) {
            e.preventDefault();

            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });


        $('.batal-penarikan-saldo').on('click', function () {
            $('#form-penarikan-saldo').trigger('reset');
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
                url: "admin/penarikan_saldo/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 6],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4, 5, 6], "className": 'text-center' }]
        });
      
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modalPenarikanSaldo'),
            theme:"bootstrap4"
        });

        

    });

});




function cekId(){

    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_saldo/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_penarikan_saldo').val(responsdata);
        }
    });
}

function cekSaldoBankmini(){

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_saldo/ceksaldobankmini',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#saldo_bankmini').val(uang.format(responsdata));
        }
    });
}


function tambah() {

    // ambil data dari elemen html
    const id_penarikan_saldo = $('#id_penarikan_saldo').val();
    const nama_penarik_saldo = $('#nama_penarik_saldo').val();
    const keterangan_penarikan_saldo = $('#keterangan_penarikan_saldo').val();
    const tanggal_transaksi_penarikan_saldo = $('#tanggal_transaksi_penarikan_saldo').val();
    const jumlah_penarikan_saldo = $('#jumlah_penarikan_saldo').val();
    const id_pengguna = $('#id_pengguna').val();

    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_penarikan_saldo', id_penarikan_saldo);
    data.append('nama_penarik_saldo', nama_penarik_saldo);
    data.append('keterangan_penarikan_saldo', keterangan_penarikan_saldo);
    data.append('tanggal_transaksi_penarikan_saldo', tanggal_transaksi_penarikan_saldo);
    data.append('jumlah_penarikan_saldo', jumlah_penarikan_saldo);
    data.append('id_pengguna', id_pengguna);


    let arr_field = [nama_penarik_saldo, tanggal_transaksi_penarikan_saldo,jumlah_penarikan_saldo,keterangan_penarikan_saldo];
    let arr_name = ["Nama Penarik", "Tanggal Transaksi","Jumlah Penarikan","Keterangan Penarikan"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_saldo/tambah',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);            
            // tutup modal
            $('#modalPenarikanSaldo').modal('hide');

            $('#form-penarikan-saldo').trigger('reset');
            //refresh table
            dataTable.ajax.reload();
        }
    });
}


function cekValidasiForm(data, name) {
    let pesan_validasi = '';
    let feedback = '';
    for (var i = 0; i < data.length; i++) {
        if (data[i] == '') {
            pesan_validasi = 'Data ' + name[i] + ' tidak boleh kosong.';
        }
    }

    if (pesan_validasi != '') {
        alertData('error', 'Validasi Gagal...!', pesan_validasi);
        feedback = 'gagal';
    }
    return feedback;

}


//fungsi untuk mengeset value pada modal ubah
function btnModalUbah(id_penarikan_saldo) {
    $('#modalPenarikanSaldoLabel').html('Ubah Penarikan Saldo');
    $('#btn-modalPenarikanSaldo').html('Ubah');
    

    let data = new FormData();
    data.append('id_penarikan_saldo', id_penarikan_saldo);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_saldo/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_penarikan_saldo').val(responsdata.id_penarikan_saldo);
            $('#tanggal_transaksi_penarikan_saldo').val(responsdata.tanggal_transaksi_penarikan_saldo);     
            $('#nama_penarik_saldo').val(responsdata.nama_penarik_saldo);
            $('#keterangan_penarikan_saldo').val(responsdata.keterangan_penarikan_saldo);
            $('#jumlah_penarikan_saldo').val(responsdata.jumlah_penarikan_saldo);
            $('#nama_pengguna').html('<option value="'+responsdata.id_pengguna+'">'+responsdata.nama_pengguna+'</option>');


            cekSaldoBankmini();
            
        }
    });

}

function ubah() {

     // ambil data dari elemen html
     const id_penarikan_saldo = $('#id_penarikan_saldo').val();
     const nama_penarik_saldo = $('#nama_penarik_saldo').val();
     const keterangan_penarikan_saldo = $('#keterangan_penarikan_saldo').val();
     const tanggal_transaksi_penarikan_saldo = $('#tanggal_transaksi_penarikan_saldo').val();
     const jumlah_penarikan_saldo = $('#jumlah_penarikan_saldo').val();
     const id_pengguna = $('#id_pengguna').val();
 
     // simpan data dalam bentuk object dengan nama data
     let data = new FormData();
     data.append('id_penarikan_saldo', id_penarikan_saldo);
     data.append('nama_penarik_saldo', nama_penarik_saldo);
     data.append('keterangan_penarikan_saldo', keterangan_penarikan_saldo);
     data.append('tanggal_transaksi_penarikan_saldo', tanggal_transaksi_penarikan_saldo);
     data.append('jumlah_penarikan_saldo', jumlah_penarikan_saldo);
     data.append('id_pengguna', id_pengguna);
 
 
     let arr_field = [nama_penarik_saldo, tanggal_transaksi_penarikan_saldo,jumlah_penarikan_saldo,keterangan_penarikan_saldo];
     let arr_name = ["Nama Penarik", "Tanggal Transaksi","Jumlah Penarikan","Keterangan Penarikan"];
     let hasil_cek = cekValidasiForm(arr_field, arr_name);
     if (hasil_cek == 'gagal') {
         return 'false';
     }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_saldo/ubah',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);

            $('#form-penarikan-saldo').trigger('reset');
            // tutup modal
            $('#modalPenarikanSaldo').modal('hide');
            
            //refresh table
            dataTable.ajax.reload();
        }
    });
}

function btnModalHapus(id_penarikan_saldo) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_penarikan_saldo)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_penarikan_saldo) {
    let data = new FormData();
    data.append('id_penarikan_saldo', id_penarikan_saldo);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_saldo/hapus',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);

            //refresh table
            dataTable.ajax.reload();
        }
    });
}



function btnDetail(id_penarikan_saldo) {
    $('#modalDetailPenarikanSaldoLabel').html('Detail Penarikan Saldo');
    var data = new FormData();
    data.append('id_penarikan_saldo', id_penarikan_saldo);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_saldo/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_penarikan_saldo2').html(responsdata.id_penarikan_saldo);
            $('#tanggal_transaksi_penarikan_saldo2').html(responsdata.tanggal_transaksi_penarikan_saldo);            
            $('#nama_penarik_saldo2').html(responsdata.nama_penarik_saldo);
            $('#keterangan_penarikan_saldo2').html(responsdata.keterangan_penarikan_saldo);
            $('#jumlah_penarikan_saldo2').html(uang.format(responsdata.jumlah_penarikan_saldo));
            $('#nama_pengguna2').html(responsdata.nama_pengguna);
            $('#id_penarikan_saldo_cetak').val(responsdata.id_penarikan_saldo);
        }
    });

}