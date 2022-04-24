const baseurl = document.getElementById('baseurl').value;
let dataTable;
window.addEventListener('load', function () {
    $(document).ready(function () {


        $('#btn-naik').on('click', function (e) {
            let tipe = 'warning';
            let title = 'Konfirmasi!';
            let pesan = 'Yakin akan menaikan kelas semua siswa?';
            let textBtn = 'Ya, Naikan...!';
            alertConfirm(tipe, title, pesan, textBtn, function (confirmed) {
                if (confirmed) {
                    // YES
                    aksiNaik()
        
                } else {
                    // NO
        
                }
            });

        });


       


    });

});



function aksiNaik() {
    alertLoading(); 
    $.ajax({
        //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
        url: 'admin/naik_kelas/naik',
        type: 'POST',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'JSON',
        success: function (responsdata) {
            alertData(responsdata.status, responsdata.title, responsdata.pesan);
           
        }
    });
}


