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
            $('#modalPenarikanTabunganLabel').html('Tambah Penarikan Tabungan');
            $('#btn-modalPenarikanTabungan').html('Tambah');
            cekId();
            getIdNasabah();

        });
        
        $('#btn-cekHariIniModal').on('click', function () {
            $('#modalCekHariIniLabel').html('Cek Hari Ini');
        });

        $('#btn-cekSemuaPenarikanModal').on('click', function () {
            $('#modalCekSemuaPenarikanLabel').html('Cek Semua Penarikan');
        });

        $('#btn-exportPenarikanTabunganPerTanggalModal').on('click', function () {
            $('#modalExportPenarikanTabunganPerTanggalLabel').html('Export Penarikan Tabungan Per Tanggal');
        });

        
        $('#btn-modalPenarikanTabungan').on('click', function (e) {
            e.preventDefault();

            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });


        $('.batal-penarikan-tabungan').on('click', function () {
            $('#form-penarikan-tabungan').trigger('reset');
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
                url: "admin/penarikan_tabungan/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 8],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8], "className": 'text-center' }]
        });
      
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modalPenarikanTabungan'),
            theme:"bootstrap4"
        });

        $('#id_nasabah').change(function(){
            let id_nasabah = $(this).val();
            if(id_nasabah != ""){
                setFormTambah(id_nasabah);
                cekSaldoSebelumnya(id_nasabah);
            }else{
                clear();
            }
        });
        
        getIdNasabah();

    });

});


function clear(){
    $('#id_nasabah').val("");
    $('#nama_nasabah').val("");           
    $('#alamat_nasabah').val("");
    $('#no_tanda_pengenal_nasabah').val("");
    $('#kelas').val("");
    $('#saldo_sebelumnya').val("");
}

function cekId(){

    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_penarikan_tabungan').val(responsdata);
        }
    });
}

function cekSaldoSebelumnya(id_nasabah){

    let data = new FormData();
    data.append('id_nasabah', id_nasabah);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/ceksaldosebelumnya',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#saldo_sebelumnya').val(uang.format(responsdata));
        }
    });
}

function setFormTambah(id_nasabah){
    let data = new FormData();
    data.append('id_nasabah', id_nasabah);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/getNasabahById',
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


function getIdNasabah() {

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/getIdNasabah',
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


function tambah() {

    // ambil data dari elemen html
    const id_penarikan_tabungan = $('#id_penarikan_tabungan').val();
    const id_nasabah = $('#id_nasabah').val();
    const keterangan_penarikan_tabungan = $('#keterangan_penarikan_tabungan').val();
    const tanggal_transaksi_penarikan_tabungan = $('#tanggal_transaksi_penarikan_tabungan').val();
    const jumlah_penarikan_tabungan = $('#jumlah_penarikan_tabungan').val();
    const id_pengguna = $('#id_pengguna').val();

    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_penarikan_tabungan', id_penarikan_tabungan);
    data.append('id_nasabah', id_nasabah);
    data.append('keterangan_penarikan_tabungan', keterangan_penarikan_tabungan);
    data.append('tanggal_transaksi_penarikan_tabungan', tanggal_transaksi_penarikan_tabungan);
    data.append('jumlah_penarikan_tabungan', jumlah_penarikan_tabungan);
    data.append('id_pengguna', id_pengguna);


    let arr_field = [id_nasabah, tanggal_transaksi_penarikan_tabungan,jumlah_penarikan_tabungan,keterangan_penarikan_tabungan];
    let arr_name = ["ID Nasabah", "Tanggal Transaksi","Jumlah Penarikan","Keterangan Penarikan"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/tambah',
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
            $('#modalPenarikanTabungan').modal('hide');

            $('#form-penarikan-tabungan').trigger('reset');
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
function btnModalUbah(id_penarikan_tabungan) {
    $('#modalPenarikanTabunganLabel').html('Ubah Penarikan Tabungan');
    $('#btn-modalPenarikanTabungan').html('Ubah');
    

    let data = new FormData();
    data.append('id_penarikan_tabungan', id_penarikan_tabungan);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_penarikan_tabungan').val(responsdata.id_penarikan_tabungan);
            $('#tanggal_transaksi_penarikan_tabungan').val(responsdata.tanggal_transaksi_penarikan_tabungan);          
            $('#id_nasabah').val(responsdata.id_nasabah).trigger('change');          
            $('#nama_nasabah').val(responsdata.nama_nasabah);
            $('#keterangan_penarikan_tabungan').val(responsdata.keterangan_penarikan_tabungan);
            $('#jumlah_penarikan_tabungan').val(responsdata.jumlah_penarikan_tabungan);
            $('#no_tanda_pengenal_nasabah').val(responsdata.no_tanda_pengenal_nasabah);
            $('#kelas').val(responsdata.tingkat +' '+ responsdata.kode_jurusan + ' ' + responsdata.rombel);  
            $('#alamat_nasabah').val(responsdata.alamat_nasabah);
            $('#nama_pengguna').html('<option value="'+responsdata.id_pengguna+'">'+responsdata.nama_pengguna+'</option>');


            cekSaldoSebelumnya(responsdata.id_nasabah);
            
        }
    });

}

function ubah() {

     // ambil data dari elemen html
     const id_penarikan_tabungan = $('#id_penarikan_tabungan').val();
     const id_nasabah = $('#id_nasabah').val();
     const keterangan_penarikan_tabungan = $('#keterangan_penarikan_tabungan').val();
     const tanggal_transaksi_penarikan_tabungan = $('#tanggal_transaksi_penarikan_tabungan').val();
     const jumlah_penarikan_tabungan = $('#jumlah_penarikan_tabungan').val();
     const id_pengguna = $('#id_pengguna').val();
 
     // simpan data dalam bentuk object dengan nama data
     let data = new FormData();
     data.append('id_penarikan_tabungan', id_penarikan_tabungan);
     data.append('id_nasabah', id_nasabah);
     data.append('keterangan_penarikan_tabungan', keterangan_penarikan_tabungan);
     data.append('tanggal_transaksi_penarikan_tabungan', tanggal_transaksi_penarikan_tabungan);
     data.append('jumlah_penarikan_tabungan', jumlah_penarikan_tabungan);
     data.append('id_pengguna', id_pengguna);
 
 
     let arr_field = [id_nasabah, tanggal_transaksi_penarikan_tabungan,jumlah_penarikan_tabungan,keterangan_penarikan_tabungan];
     let arr_name = ["ID Nasabah", "Tanggal Transaksi","Jumlah Penarikan","Keterangan Penarikan"];
     let hasil_cek = cekValidasiForm(arr_field, arr_name);
     if (hasil_cek == 'gagal') {
         return 'false';
     }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/ubah',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);

            $('#form-penarikan-tabungan').trigger('reset');
            // tutup modal
            $('#modalPenarikanTabungan').modal('hide');
            
            //refresh table
            dataTable.ajax.reload();
        }
    });
}

function btnModalHapus(id_penarikan_tabungan) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_penarikan_tabungan)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_penarikan_tabungan) {
    let data = new FormData();
    data.append('id_penarikan_tabungan', id_penarikan_tabungan);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/hapus',
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



function btnDetail(id_penarikan_tabungan) {
    $('#modalDetailPenarikanTabunganLabel').html('Detail Penarikan Tabungan');
    var data = new FormData();
    data.append('id_penarikan_tabungan', id_penarikan_tabungan);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/penarikan_tabungan/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_penarikan_tabungan2').html(responsdata.id_penarikan_tabungan);
            $('#tanggal_transaksi_penarikan_tabungan2').html(responsdata.tanggal_transaksi_penarikan_tabungan);
            $('#id_nasabah2').html(responsdata.id_nasabah);
            $('#nama_nasabah2').html(responsdata.nama_nasabah);
            $('#keterangan_penarikan_tabungan2').html(responsdata.keterangan_penarikan_tabungan);
            $('#jumlah_penarikan_tabungan2').html(uang.format(responsdata.jumlah_penarikan_tabungan));
            $('#no_tanda_pengenal_nasabah2').html(responsdata.no_tanda_pengenal_nasabah);
            $('#kelas2').html(responsdata.tingkat +' '+ responsdata.kode_jurusan + ' ' + responsdata.rombel);
            $('#alamat_nasabah2').html(responsdata.alamat_nasabah);
            $('#nama_pengguna2').html(responsdata.nama_pengguna);
            $('#id_penarikan_tabungan_cetak').val(responsdata.id_penarikan_tabungan);
        }
    });

}