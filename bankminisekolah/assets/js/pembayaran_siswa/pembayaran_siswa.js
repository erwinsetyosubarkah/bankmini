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
            $('#modalPembayaranSiswaLabel').html('Tambah Pembayaran Siswa');
            $('#btn-modalPembayaranSiswa').html('Tambah');
            cekId();
            getIdNasabah();
            getIdJenisSetoran();

        });
        
        $('#btn-cekHariIniModal').on('click', function () {
            $('#modalCekHariIniLabel').html('Cek Hari Ini');
        });

        $('#btn-cekSemuaSetoranModal').on('click', function () {
            $('#modalCekSemuaSetoranLabel').html('Cek Semua Setoran');
        });

        $('#btn-exportPembayaranSiswaPerTanggalModal').on('click', function () {
            $('#modalExportPembayaranSiswaPerTanggalLabel').html('Export Pembayaran Siswa Per Tanggal');
        });

        
        $('#btn-modalPembayaranSiswa').on('click', function (e) {
            e.preventDefault();

            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });


        $('.batal-pembayaran-siswa').on('click', function () {
            $('#form-pembayaran-siswa').trigger('reset');
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
                url: "admin/pembayaran_siswa/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 8],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8], "className": 'text-center' }]
        });
      
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modalPembayaranSiswa'),
            theme:"bootstrap4"
        });

        $('#id_nasabah').change(function(){
            let id_nasabah = $(this).val();
            if(id_nasabah != ""){
                setFormTambah(id_nasabah);
            }else{
                clear();
            }
        });
        
        getIdNasabah();
        getIdJenisSetoran();

    });

});


function clear(){
    $('#id_nasabah').val("");
    $('#nama_nasabah').val("");           
    $('#alamat_nasabah').val("");
    $('#no_tanda_pengenal_nasabah').val("");
    $('#kelas').val("");
}

function cekId(){

    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pembayaran_siswa/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_pembayaran_siswa').val(responsdata);
        }
    });
}


function setFormTambah(id_nasabah){
    let data = new FormData();
    data.append('id_nasabah', id_nasabah);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pembayaran_siswa/getNasabahById',
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
        url: 'admin/pembayaran_siswa/getIdNasabah',
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
function getIdJenisSetoran() {
    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pembayaran_siswa/getIdJenisSetoran',
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_jenis_setoran').html(responsdata);
        }
    });
}


function tambah() {

    // ambil data dari elemen html
    const id_pembayaran_siswa = $('#id_pembayaran_siswa').val();
    const id_nasabah = $('#id_nasabah').val();
    const id_jenis_setoran = $('#id_jenis_setoran').val();
    const tanggal_transaksi_pembayaran_siswa = $('#tanggal_transaksi_pembayaran_siswa').val();
    const jumlah_pembayaran_siswa = $('#jumlah_pembayaran_siswa').val();
    const id_pengguna = $('#id_pengguna').val();

    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_pembayaran_siswa', id_pembayaran_siswa);
    data.append('id_nasabah', id_nasabah);
    data.append('id_jenis_setoran', id_jenis_setoran);
    data.append('tanggal_transaksi_pembayaran_siswa', tanggal_transaksi_pembayaran_siswa);
    data.append('jumlah_pembayaran_siswa', jumlah_pembayaran_siswa);
    data.append('id_pengguna', id_pengguna);


    let arr_field = [id_nasabah, tanggal_transaksi_pembayaran_siswa,jumlah_pembayaran_siswa,id_jenis_setoran];
    let arr_name = ["ID Nasabah", "Tanggal Transaksi","Jumlah Setoran","Jenis Setoran"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pembayaran_siswa/tambah',
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
            $('#modalPembayaranSiswa').modal('hide');

            $('#form-pembayaran-siswa').trigger('reset');
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
function btnModalUbah(id_pembayaran_siswa) {
    $('#modalPembayaranSiswaLabel').html('Ubah Pembayaran Siswa');
    $('#btn-modalPembayaranSiswa').html('Ubah');
    

    let data = new FormData();
    data.append('id_pembayaran_siswa', id_pembayaran_siswa);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pembayaran_siswa/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_pembayaran_siswa').val(responsdata.id_pembayaran_siswa);
            $('#tanggal_transaksi_pembayaran_siswa').val(responsdata.tanggal_transaksi_pembayaran_siswa);          
            $('#id_nasabah').val(responsdata.id_nasabah).trigger('change');          
            $('#nama_nasabah').val(responsdata.nama_nasabah);
            $('#id_jenis_setoran').val(responsdata.id_jenis_setoran).trigger('change');          
            $('#jumlah_pembayaran_siswa').val(responsdata.jumlah_pembayaran_siswa);
            $('#no_tanda_pengenal_nasabah').val(responsdata.no_tanda_pengenal_nasabah);
            $('#kelas').val(responsdata.tingkat +' '+ responsdata.kode_jurusan + ' ' + responsdata.rombel);  
            $('#alamat_nasabah').val(responsdata.alamat_nasabah);
            $('#nama_pengguna').html('<option value="'+responsdata.id_pengguna+'">'+responsdata.nama_pengguna+'</option>');


            
        }
    });

}

function ubah() {

    // ambil data dari elemen html
    const id_pembayaran_siswa = $('#id_pembayaran_siswa').val();
    const id_nasabah = $('#id_nasabah').val();
    const id_jenis_setoran = $('#id_jenis_setoran').val();
    const tanggal_transaksi_pembayaran_siswa = $('#tanggal_transaksi_pembayaran_siswa').val();
    const jumlah_pembayaran_siswa = $('#jumlah_pembayaran_siswa').val();
    const id_pengguna = $('#id_pengguna').val();

    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_pembayaran_siswa', id_pembayaran_siswa);
    data.append('id_nasabah', id_nasabah);
    data.append('id_jenis_setoran', id_jenis_setoran);
    data.append('tanggal_transaksi_pembayaran_siswa', tanggal_transaksi_pembayaran_siswa);
    data.append('jumlah_pembayaran_siswa', jumlah_pembayaran_siswa);
    data.append('id_pengguna', id_pengguna);


    let arr_field = [id_nasabah, tanggal_transaksi_pembayaran_siswa,jumlah_pembayaran_siswa,id_jenis_setoran];
    let arr_name = ["ID Nasabah", "Tanggal Transaksi","Jumlah Setoran","Jenis Setoran"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pembayaran_siswa/ubah',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);

            $('#form-pembayaran-siswa').trigger('reset');
            // tutup modal
            $('#modalPembayaranSiswa').modal('hide');
            
            //refresh table
            dataTable.ajax.reload();
        }
    });
}

function btnModalHapus(id_pembayaran_siswa) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_pembayaran_siswa)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_pembayaran_siswa) {
    let data = new FormData();
    data.append('id_pembayaran_siswa', id_pembayaran_siswa);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pembayaran_siswa/hapus',
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



function btnDetail(id_pembayaran_siswa) {
    $('#modalDetailPembayaranSiswaLabel').html('Detail Pembayaran Siswa');
    var data = new FormData();
    data.append('id_pembayaran_siswa', id_pembayaran_siswa);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pembayaran_siswa/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_pembayaran_siswa2').html(responsdata.id_pembayaran_siswa);
            $('#tanggal_transaksi_pembayaran_siswa2').html(responsdata.tanggal_transaksi_pembayaran_siswa);
            $('#id_nasabah2').html(responsdata.id_nasabah);
            $('#nama_nasabah2').html(responsdata.nama_nasabah);
            $('#jenis_setoran2').html(responsdata.jenis_setoran);
            $('#jumlah_pembayaran_siswa2').html(uang.format(responsdata.jumlah_pembayaran_siswa));
            $('#no_tanda_pengenal_nasabah2').html(responsdata.no_tanda_pengenal_nasabah);
            $('#kelas2').html(responsdata.tingkat +' '+ responsdata.kode_jurusan + ' ' + responsdata.rombel);
            $('#alamat_nasabah2').html(responsdata.alamat_nasabah);
            $('#nama_pengguna2').html(responsdata.nama_pengguna);
            $('#id_pembayaran_siswa_cetak').val(responsdata.id_pembayaran_siswa);
        }
    });

}