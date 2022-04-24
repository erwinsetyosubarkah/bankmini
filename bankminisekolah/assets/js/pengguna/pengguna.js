const baseurl = document.getElementById('baseurl').value;
let dataTable;
window.addEventListener('load', function () {
    $(document).ready(function () {



        $('#btn-tambahModal').on('click', function () {
            $('#modalPenggunaLabel').html('Tambah Pengguna');
            $('#btn-modalPengguna').html('Tambah');
            cekId();
        });

        $('.batal-pengguna').on('click', function () {
            clearURL($('#foto_pengguna'));
        });


        $('#foto_pengguna').change(function () {
            readURL(this);
        });

        $('#btn-modalPengguna').on('click', function (e) {
            e.preventDefault();

            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });



        $('.batal-pengguna').on('click', function () {
            $('#form-pengguna').trigger('reset');
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
                url: "admin/pengguna/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 6, 8],
                "orderable": false,
            }, { "targets": [0, 1, 3, 4, 5, 6, 7, 8], "className": 'text-center' }]
        });





    });

});



function clearURL(input) {
    var txt = '<img src="" alt="" style="height: 80px;" id="img_foto_pengguna">';
    $('.foto-prev').html(txt);

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_foto_pengguna').attr('src', '');
        }

        reader.readAsDataURL(input.files[0]);
    }
    $('#form-pengguna').trigger('reset');
}



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_foto_pengguna').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}



function cekId(){

    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pengguna/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_pengguna').val(responsdata);
        }
    });
}

function tambah() {

    // ambil data dari elemen html
    const id_pengguna = $('#id_pengguna').val();
    const nama_pengguna = $('#nama_pengguna').val();
    const username = $('#username').val();
    const status_pengguna = $('#status_pengguna').val();
    const level = $('#level').val();
    const foto_pengguna = $('#foto_pengguna').prop('files')[0];

    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_pengguna', id_pengguna);
    data.append('nama_pengguna', nama_pengguna);
    data.append('username', username);
    data.append('status_pengguna', status_pengguna);
    data.append('level', level);
    data.append('foto_pengguna', foto_pengguna);

    let arr_field = [nama_pengguna,username];
    let arr_name = ["Nama", "Username"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pengguna/tambah',
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
            clearURL($('#foto_pengguna'));
            // tutup modal
            $('#modalPengguna').modal('hide');
            

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
function btnModalUbah(id_pengguna) {
    $('#modalPenggunaLabel').html('Ubah Pengguna');
    $('#btn-modalPengguna').html('Ubah');
    
    let data = new FormData();
    data.append('id_pengguna', id_pengguna);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pengguna/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_pengguna').val(responsdata.id_pengguna);
            $('#nama_pengguna').val(responsdata.nama_pengguna);
            $('#username').val(responsdata.username);
            $('#username_lama').val(responsdata.username);
            $('#status_pengguna').val(responsdata.status_pengguna).trigger('change');
            $('#level').val(responsdata.level).trigger('change');         
            $('#foto_pengguna_lama').val(responsdata.foto_pengguna);
            $('#img_foto_pengguna').attr('src', baseurl + 'assets/img/foto/' + responsdata.foto_pengguna);
        }
    });

}

function ubah() {

    // ambil data dari elemen html
    const id_pengguna = $('#id_pengguna').val();
    const nama_pengguna = $('#nama_pengguna').val();
    const username = $('#username').val();
    const username_lama = $('#username_lama').val();
    const status_pengguna = $('#status_pengguna').val();
    const level = $('#level').val();   
    const foto_pengguna_lama = $('#foto_pengguna_lama').val();
    const foto_pengguna = $('#foto_pengguna').prop('files')[0];

    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_pengguna', id_pengguna);
    data.append('nama_pengguna', nama_pengguna);
    data.append('username', username);
    data.append('username_lama', username_lama);
    data.append('status_pengguna', status_pengguna);
    data.append('level', level);
    data.append('foto_pengguna_lama', foto_pengguna_lama);
    data.append('foto_pengguna', foto_pengguna);

    let arr_field = [nama_pengguna, username];
    let arr_name = ["Nama", "Username"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pengguna/ubah',
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
            clearURL($('#foto_pengguna'));
            // tutup modal
            $('#modalPengguna').modal('hide');

            //refresh table
            dataTable.ajax.reload();
        }
    });
}

function btnModalHapus(id_pengguna) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_pengguna)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_pengguna) {
    let data = new FormData();
    data.append('id_pengguna', id_pengguna);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pengguna/hapus',
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

function btnResetPassword(id_pengguna) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan mereset password akun ini?';
    let textBtn = 'Ya, Reset...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiResetPassword(id_pengguna)

        } else {
            // NO

        }
    });


}

function aksiResetPassword(id_pengguna) {
    var data = new FormData();
    data.append('id_pengguna', id_pengguna);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pengguna/resetPassword',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);

        }
    });
}

function btnDetail(id_pengguna) {
    $('#modalDetailPenggunaLabel').html('Detail Pengguna');
    var data = new FormData();
    data.append('id_pengguna', id_pengguna);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/pengguna/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#img_foto_pengguna2').attr('src', baseurl + 'assets/img/foto/' + responsdata.foto_pengguna);
            $('#head_nama_pengguna2').html(responsdata.nama_pengguna);
            $('#id_pengguna2').html(responsdata.id_pengguna);
            $('#nama_pengguna2').html(responsdata.nama_pengguna);
            $('#username2').html(responsdata.username);
            $('#status_pengguna2').html(responsdata.status_pengguna);
            $('#level2').html(responsdata.level);
            $('#tgl_login2').html(responsdata.tgl_login);
        }
    });

}