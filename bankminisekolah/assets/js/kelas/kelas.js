const baseurl = document.getElementById('baseurl').value;
let dataTable;
window.addEventListener('load', function () {
    $(document).ready(function () {

        $('#btn-tambahModal').on('click', function () {
            $('#modalKelasLabel').html('Tambah Kelas');
            $('#btn-modalKelas').html('Tambah');
            cekId();
            getTingkat();

        });


        $('#btn-modalKelas').on('click', function (e) {
            e.preventDefault();
            if ($(this).html() == 'Tambah') {
                tambah();

            } else if ($(this).html() == 'Ubah') {
                ubah();
            }

        });


        $('.batal-kelas').on('click', function () {
            $('#form-kelas').trigger('reset');
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
                url: "admin/kelas/queryAll",
                method: "POST"
            },
            "columnDefs": [{
                "targets": [0, 6],
                "orderable": false,
            }, { "targets": [0, 1, 2, 3, 4, 5, 6], "className": 'text-center' }]
        });


    });
});


function cekId(){

    
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/kelas/cekid',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_kelas').val(responsdata);
        }
    });
}

function getTingkat() {

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/kelas/getJurusan',
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_jurusan').html(responsdata);
        }
    });
}

function tambah() {

    // ambil data dari elemen html
    const id_kelas = $('#id_kelas').val();
    const id_jurusan = $('#id_jurusan').val();
    const tingkat = $('#tingkat').val();
    const rombel = $('#rombel').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_kelas', id_kelas);
    data.append('id_jurusan', id_jurusan);
    data.append('tingkat', tingkat);
    data.append('rombel', rombel);


    let arr_field = [id_jurusan, rombel];
    let arr_name = ["Jurusan", "Rombel"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/kelas/tambah',
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
            $('#form-kelas').trigger('reset');
            // tutup modal
            $('#modalKelas').modal('hide');

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
function btnModalUbah(id_kelas) {
    $('#modalKelasLabel').html('Ubah Kelas');
    $('#btn-modalKelas').html('Ubah');
    getTingkat();

    let data = new FormData();
    data.append('id_kelas', id_kelas);

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/kelas/queryById',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            $('#id_kelas').val(responsdata.id_kelas);
            $('#id_jurusan').val(responsdata.id_jurusan).trigger('change');
            $('#tingkat').val(responsdata.tingkat).trigger('change');
            $('#rombel').val(responsdata.rombel);

        }
    });

}

function ubah() {

    // ambil data dari elemen html
    const id_kelas = $('#id_kelas').val();
    const id_jurusan = $('#id_jurusan').val();
    const tingkat = $('#tingkat').val();
    const rombel = $('#rombel').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('id_kelas', id_kelas);
    data.append('id_jurusan', id_jurusan);
    data.append('tingkat', tingkat);
    data.append('rombel', rombel);


    let arr_field = [id_jurusan, rombel];
    let arr_name = ["Jurusan", "Rombel"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/kelas/ubah',
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
            $('#form-kelas').trigger('reset');
            // tutup modal
            $('#modalKelas').modal('hide');

            //refresh table
            dataTable.ajax.reload();
        }
    });
}


function btnModalHapus(id_kelas) {
    let tipe = 'warning';
    let title = 'Konfirmasi!';
    let pesan = 'Yakin akan menghapus data ini?';
    let textBtn = 'Ya, Hapus...!';
    alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
        if (confirmed) {
            // YES
            aksiHapus(id_kelas)

        } else {
            // NO

        }
    });
}

function aksiHapus(id_kelas) {
    let data = new FormData();
    data.append('id_kelas', id_kelas);

    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/kelas/hapus',
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