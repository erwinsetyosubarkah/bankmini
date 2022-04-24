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
            $('#modalNasabahLabel').html('Tambah Nasabah');
            $('#btn-modalNasabah').html('Tambah');
            cekId();
            getTandaPengenal();
            getKelas();

        });



        $('#btn-modalNasabah').on('click', function (e) {
            e.preventDefault();

            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });


        $('.batal-nasabah').on('click', function () {
            $('#form-nasabah').trigger('reset');
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
                url: "admin/nasabah/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 7, 8],
                "orderable": false,
            }, { "targets": [0, 1, 3, 4, 5, 6, 7, 8], "className": 'text-center' }]
        });


        $('#btn-import').on('click', function (e) {
            e.preventDefault();            
            let import_data = $('#import_data').prop('files')[0];

            // simpan data dalam bentuk object dengan nama data
            let data = new FormData();
            data.append('import_data', import_data);

            alertLoading();
            $.ajax({
                //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
                url: 'admin/nasabah/importData',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'JSON',
                success: function (responsdata) {
                    alertData(responsdata.status, responsdata.title, responsdata.pesan);
                    $('#import_data').val('');

                    //refresh table
                    dataTable.ajax.reload();
                }
            });

        });


    });

});

function cekId(){

    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/nasabah/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_nasabah').val(responsdata);
        }
    });
}

function getTandaPengenal() {

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/nasabah/getTandaPengenal',
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_tanda_pengenal').html(responsdata);
        }
    });
}

function getKelas() {

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/nasabah/getKelas',
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_kelas').html(responsdata);
        }
    });
}


function tambah() {

    // ambil data dari elemen html
    const id_nasabah = $('#id_nasabah').val();
    const nama_nasabah = $('#nama_nasabah').val();
    const jenis_kelamin_nasabah = $('#jenis_kelamin_nasabah').val();
    const tempat_lahir_nasabah = $('#tempat_lahir_nasabah').val();
    const tanggal_lahir_nasabah = $('#tanggal_lahir_nasabah').val();
    const alamat_nasabah = $('#alamat_nasabah').val();
    const no_telp_nasabah = $('#no_telp_nasabah').val();
    const id_tanda_pengenal = $('#id_tanda_pengenal').val();
    const no_tanda_pengenal_nasabah = $('#no_tanda_pengenal_nasabah').val();
    const id_kelas = $('#id_kelas').val();
    const saldo_nasabah = $('#saldo_nasabah').val();

    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_nasabah', id_nasabah);
    data.append('nama_nasabah', nama_nasabah);
    data.append('jenis_kelamin_nasabah', jenis_kelamin_nasabah);
    data.append('tempat_lahir_nasabah', tempat_lahir_nasabah);
    data.append('tanggal_lahir_nasabah', tanggal_lahir_nasabah);
    data.append('alamat_nasabah', alamat_nasabah);
    data.append('no_telp_nasabah', no_telp_nasabah);
    data.append('id_tanda_pengenal', id_tanda_pengenal);
    data.append('no_tanda_pengenal_nasabah', no_tanda_pengenal_nasabah);
    data.append('id_kelas', id_kelas);
    data.append('saldo_nasabah', saldo_nasabah);

    let arr_field = [nama_nasabah, id_kelas];
    let arr_name = ["Nama", "Kelas"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/nasabah/tambah',
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
            $('#modalNasabah').modal('hide');

            $('#form-nasabah').trigger('reset');

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
function btnModalUbah(id_nasabah) {
    $('#modalNasabahLabel').html('Ubah Nasabah');
    $('#btn-modalNasabah').html('Ubah');
    getTandaPengenal();
    getKelas();

    let data = new FormData();
    data.append('id_nasabah', id_nasabah);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/nasabah/queryById',
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
            $('#jenis_kelamin_nasabah').val(responsdata.jenis_kelamin_nasabah).trigger('change');
            $('#tempat_lahir_nasabah').val(responsdata.tempat_lahir_nasabah);
            $('#tanggal_lahir_nasabah').val(responsdata.tanggal_lahir_nasabah);
            $('#alamat_nasabah').val(responsdata.alamat_nasabah);
            $('#no_telp_nasabah').val(responsdata.no_telp_nasabah);
            $('#id_tanda_pengenal').val(responsdata.id_tanda_pengenal).trigger('change');
            $('#no_tanda_pengenal_nasabah').val(responsdata.no_tanda_pengenal_nasabah);
            $('#id_kelas').val(responsdata.id_kelas).trigger('change');
            $('#saldo_nasabah').val(responsdata.saldo_nasabah);
            
        }
    });

}

function ubah() {

    // ambil data dari elemen html
    const id_nasabah = $('#id_nasabah').val();
    const nama_nasabah = $('#nama_nasabah').val();
    const jenis_kelamin_nasabah = $('#jenis_kelamin_nasabah').val();
    const tempat_lahir_nasabah = $('#tempat_lahir_nasabah').val();
    const tanggal_lahir_nasabah = $('#tanggal_lahir_nasabah').val();
    const alamat_nasabah = $('#alamat_nasabah').val();
    const no_telp_nasabah = $('#no_telp_nasabah').val();
    const id_tanda_pengenal = $('#id_tanda_pengenal').val();
    const no_tanda_pengenal_nasabah = $('#no_tanda_pengenal_nasabah').val();
    const id_kelas = $('#id_kelas').val();
    const saldo_nasabah = $('#saldo_nasabah').val();

    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_nasabah', id_nasabah);
    data.append('nama_nasabah', nama_nasabah);
    data.append('jenis_kelamin_nasabah', jenis_kelamin_nasabah);
    data.append('tempat_lahir_nasabah', tempat_lahir_nasabah);
    data.append('tanggal_lahir_nasabah', tanggal_lahir_nasabah);
    data.append('alamat_nasabah', alamat_nasabah);
    data.append('no_telp_nasabah', no_telp_nasabah);
    data.append('id_tanda_pengenal', id_tanda_pengenal);
    data.append('no_tanda_pengenal_nasabah', no_tanda_pengenal_nasabah);
    data.append('id_kelas', id_kelas);
    data.append('saldo_nasabah', saldo_nasabah);

    let arr_field = [nama_nasabah, id_kelas];
    let arr_name = ["Nama", "Kelas"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/nasabah/ubah',
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
            $('#modalNasabah').modal('hide');

            //refresh table
            dataTable.ajax.reload();
        }
    });
}

function btnModalHapus(id_nasabah) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_nasabah)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_nasabah) {
    let data = new FormData();
    data.append('id_nasabah', id_nasabah);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/nasabah/hapus',
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



function btnDetail(id_nasabah) {
    $('#modalDetailNasabahLabel').html('Detail Nasabah');
    var data = new FormData();
    data.append('id_nasabah', id_nasabah);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/nasabah/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_nasabah2').html(responsdata.id_nasabah);
            $('#nama_nasabah2').html(responsdata.nama_nasabah);
            $('#jenis_kelamin_nasabah2').html(responsdata.jenis_kelamin_nasabah);
            $('#tempat_lahir_nasabah2').html(responsdata.tempat_lahir_nasabah);
            $('#tanggal_lahir_nasabah2').html(responsdata.tanggal_lahir_nasabah);
            $('#alamat_nasabah2').html(responsdata.alamat_nasabah);
            $('#no_telp_nasabah2').html(responsdata.no_telp_nasabah);
            $('#jenis_tanda_pengenal2').html(responsdata.jenis_tanda_pengenal);
            $('#no_tanda_pengenal_nasabah2').html(responsdata.no_tanda_pengenal_nasabah);
            $('#kelas2').html(responsdata.tingkat + " " + responsdata.kode_jurusan + " " + responsdata.rombel);
            $('#saldo_nasabah2').html(uang.format(responsdata.saldo_nasabah));
        }
    });

}