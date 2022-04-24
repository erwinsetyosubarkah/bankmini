const baseurl = document.getElementById('baseurl').value;
let dataTable;
window.addEventListener('load', function () {
    $(document).ready(function () {

        $('#btn-tambahModal').on('click', function () {
            $('#modalJenisSetoranLabel').html('Tambah Jenis Setoran');
            $('#btn-modalJenisSetoran').html('Tambah');
            cekId();

        });


        $('#btn-modalJenisSetoran').on('click', function (e) {
            e.preventDefault();
            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });


        $('.batal-jenis-setoran').on('click', function () {
            $('#form-jenis-setoran').trigger('reset');
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
                url: "admin/jenis_setoran/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 3],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3], "className": 'text-center' }]
        });


    });
});


function cekId(){

    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jenis_setoran/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_jenis_setoran').val(responsdata);
        }
    });
}



function tambah() {

    // ambil data dari elemen html
    const id_jenis_setoran = $('#id_jenis_setoran').val();
    const jenis_setoran = $('#jenis_setoran').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_jenis_setoran', id_jenis_setoran);
    data.append('jenis_setoran', jenis_setoran);


    let arr_field = [jenis_setoran];
    let arr_name = ["Jenis Setoran"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jenis_setoran/tambah',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);
            //reset isi form
            $('#form-jenis-setoran').trigger('reset');
            // tutup modal
            $('#modalJenisSetoran').modal('hide');

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
function btnModalUbah(id_jenis_setoran) {
    $('#modalJenisSetoranLabel').html('Ubah Jenis Setoran');
    $('#btn-modalJenisSetoran').html('Ubah');

    let data = new FormData();
    data.append('id_jenis_setoran', id_jenis_setoran);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jenis_setoran/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_jenis_setoran').val(responsdata.id_jenis_setoran);
            $('#jenis_setoran').val(responsdata.jenis_setoran);

        }
    });

}

function ubah() {

    // ambil data dari elemen html
    const id_jenis_setoran = $('#id_jenis_setoran').val();
    const jenis_setoran = $('#jenis_setoran').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_jenis_setoran', id_jenis_setoran);
    data.append('jenis_setoran', jenis_setoran);


    let arr_field = [jenis_setoran];
    let arr_name = ["Jenis Setoran"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jenis_setoran/ubah',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);
            //reset isi form
            $('#form-jenis-setoran').trigger('reset');
            // tutup modal
            $('#modalJenisSetoran').modal('hide');

            //refresh table
            dataTable.ajax.reload();
        }
    });
}


function btnModalHapus(id_jenis_setoran) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_jenis_setoran)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_jenis_setoran) {
    let data = new FormData();
    data.append('id_jenis_setoran', id_jenis_setoran);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jenis_setoran/hapus',
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