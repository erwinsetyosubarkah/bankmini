const baseurl = document.getElementById('baseurl').value;
let dataTable;
window.addEventListener('load', function () {
    $(document).ready(function () {

        $('#btn-tambahModal').on('click', function () {
            $('#modalJurusanLabel').html('Tambah Jurusan');
            $('#btn-modalJurusan').html('Tambah');
            cekId();

        });


        $('#btn-modalJurusan').on('click', function (e) {
            e.preventDefault();
            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });


        $('.batal-jurusan').on('click', function () {
            $('#form-jurusan').trigger('reset');
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
                url: "admin/jurusan/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4], "className": 'text-center' }]
        });


    });
});


function cekId(){

    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jurusan/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_jurusan').val(responsdata);
        }
    });
}



function tambah() {

    // ambil data dari elemen html
    const id_jurusan = $('#id_jurusan').val();
    const jurusan = $('#jurusan').val();
    const kode_jurusan = $('#kode_jurusan').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_jurusan', id_jurusan);
    data.append('jurusan', jurusan);
    data.append('kode_jurusan', kode_jurusan);


    let arr_field = [jurusan, kode_jurusan];
    let arr_name = ["Jurusan", "Kode Jurusan"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jurusan/tambah',
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
            $('#form-jurusan').trigger('reset');
            // tutup modal
            $('#modalJurusan').modal('hide');

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
function btnModalUbah(id_jurusan) {
    $('#modalJurusanLabel').html('Ubah Jurusan');
    $('#btn-modalJurusan').html('Ubah');

    let data = new FormData();
    data.append('id_jurusan', id_jurusan);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jurusan/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_jurusan').val(responsdata.id_jurusan);
            $('#jurusan').val(responsdata.jurusan);
            $('#kode_jurusan').val(responsdata.kode_jurusan);

        }
    });

}

function ubah() {

    // ambil data dari elemen html
    const id_jurusan = $('#id_jurusan').val();
    const jurusan = $('#jurusan').val();
    const kode_jurusan = $('#kode_jurusan').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_jurusan', id_jurusan);
    data.append('jurusan', jurusan);
    data.append('kode_jurusan', kode_jurusan);


    let arr_field = [jurusan, kode_jurusan];
    let arr_name = ["Jurusan", "Kode Jurusan"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jurusan/ubah',
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
            $('#form-jurusan').trigger('reset');
            // tutup modal
            $('#modalJurusan').modal('hide');

            //refresh table
            dataTable.ajax.reload();
        }
    });
}


function btnModalHapus(id_jurusan) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_jurusan)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_jurusan) {
    let data = new FormData();
    data.append('id_jurusan', id_jurusan);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/jurusan/hapus',
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