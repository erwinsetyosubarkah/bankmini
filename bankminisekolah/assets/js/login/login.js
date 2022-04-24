const baseurl = document.getElementById('baseurl').value;

window.addEventListener('load', function () {
    $(document).ready(function () {

        $('#btn-masuk').on('click', function (e) {
            e.preventDefault();

            masuk();

        });


    });
});


function masuk() {
    const username = $('#username').val();
    const password = $('#password').val();

    let data = new FormData();
    data.append('username', username);
    data.append('password', password);

    let arr_field = [password, username];
    let arr_name = ["Password", "Username"];
    let hasil_cek = cekValidasiForm(arr_field, arr_name);
    if (hasil_cek == 'gagal') {
        return 'false';
    }
    alertLoading(); 
    //jalankan ajax
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/login/cek_user',
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {            
            alertData(responsdata.status, responsdata.title, responsdata.pesan);
            if (responsdata.status == 'success') {

                setTimeout(loginSuccess, 2000)


            }
        }
    });

}

function loginSuccess() {
    window.location.href = baseurl + 'beranda-admin';
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