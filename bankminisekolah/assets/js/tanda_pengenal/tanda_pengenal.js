const baseurl = document.getElementById('baseurl').value;
let dataTable;
window.addEventListener('load', function () {
    $(document).ready(function () {

        $('#btn-tambahModal').on('click', function () {
            $('#modalTandaPengenalLabel').html('Tambah Tanda Pengenal');
            $('#btn-modalTandaPengenal').html('Tambah');
            cekId();

        });


        $('#btn-modalTandaPengenal').on('click', function (e) {
            e.preventDefault();
            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });


        $('.batal-tanda-pengenal').on('click', function () {
            $('#form-tanda-pengenal').trigger('reset');
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
                url: "admin/tanda_pengenal/queryAll",
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
        url: 'admin/tanda_pengenal/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_tanda_pengenal').val(responsdata);
        }
    });
}



function tambah() {

    // ambil data dari elemen html
    const id_tanda_pengenal = $('#id_tanda_pengenal').val();
    const jenis_tanda_pengenal = $('#jenis_tanda_pengenal').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_tanda_pengenal', id_tanda_pengenal);
    data.append('jenis_tanda_pengenal', jenis_tanda_pengenal);


    let arr_field = [jenis_tanda_pengenal];
    let arr_name = ["Jenis Tanda Pengenal"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/tanda_pengenal/tambah',
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
            $('#form-tanda-pengenal').trigger('reset');
            // tutup modal
            $('#modalTandaPengenal').modal('hide');

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
function btnModalUbah(id_tanda_pengenal) {
    $('#modalTandaPengenalLabel').html('Ubah Tanda Pengenal');
    $('#btn-modalTandaPengenal').html('Ubah');

    let data = new FormData();
    data.append('id_tanda_pengenal', id_tanda_pengenal);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/tanda_pengenal/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_tanda_pengenal').val(responsdata.id_tanda_pengenal);
            $('#jenis_tanda_pengenal').val(responsdata.jenis_tanda_pengenal);

        }
    });

}

function ubah() {

    // ambil data dari elemen html
    const id_tanda_pengenal = $('#id_tanda_pengenal').val();
    const jenis_tanda_pengenal = $('#jenis_tanda_pengenal').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_tanda_pengenal', id_tanda_pengenal);
    data.append('jenis_tanda_pengenal', jenis_tanda_pengenal);


    let arr_field = [jenis_tanda_pengenal];
    let arr_name = ["Jenis Tanda Pengenal"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/tanda_pengenal/ubah',
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
            $('#form-tanda-pengenal').trigger('reset');
            // tutup modal
            $('#modalTandaPengenal').modal('hide');

            //refresh table
            dataTable.ajax.reload();
        }
    });
}


function btnModalHapus(id_tanda_pengenal) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_tanda_pengenal)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_tanda_pengenal) {
    let data = new FormData();
    data.append('id_tanda_pengenal', id_tanda_pengenal);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/tanda_pengenal/hapus',
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