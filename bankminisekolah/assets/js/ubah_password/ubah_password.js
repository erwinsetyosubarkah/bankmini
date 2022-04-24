
window.addEventListener('load', function () {
    $(document).ready(function () {


        $('#btn-modalUbahPassword').on('click', function (e) {
            e.preventDefault();
            ubahPassword();

        });

        $('.batal-ubah-password').on('click', function () {
            $('#form-ubah-password').trigger('reset');
        });



    });
});





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


function ubahPassword() {

    // ambil data dari elemen html
    const password_baru = $('#password_baru').val();
    const confirm_password_baru = $('#confirm_password_baru').val();


    // simpan data dalam bentuk object dengan nama data
    let data = new FormData();
    data.append('password_baru', password_baru);
    data.append('confirm_password_baru', confirm_password_baru);


    let arr_field = [password_baru, confirm_password_baru];
    let arr_name = ["Password Baru", "Tulis Ulang Password Baru"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }

    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/ubah_password/ubah',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);
            if (responsdata.status != 'error') {
                //reset isi form
                $('#form-ubah-password').trigger('reset');
                // tutup modal
                $('#modalUbahPassword').modal('hide');
            }

        }
    });
}


