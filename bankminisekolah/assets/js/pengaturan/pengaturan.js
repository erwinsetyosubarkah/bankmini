window.addEventListener('load', function () {
    $(document).ready(function () {

        const baseurl = $('#baseurl').val();


        function query() {
            $.ajax({
                //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
                url: 'admin/pengaturan/query',
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'JSON',
                success: function (responsdata) {
                    $('#nama_sekolah').val(responsdata.nama_sekolah);
                    $('#jalan').val(responsdata.jalan);
                    $('#rt').val(responsdata.rt);
                    $('#rw').val(responsdata.rw);
                    $('#kelurahan').val(responsdata.kelurahan);
                    $('#kecamatan').val(responsdata.kecamatan);
                    $('#kabupaten_kota').val(responsdata.kabupaten_kota);
                    $('#provinsi').val(responsdata.provinsi);
                    $('#kode_pos').val(responsdata.kode_pos);
                    $('#website').val(responsdata.website);
                    $('#email').val(responsdata.email);
                    $('#telp').val(responsdata.telp);
                    $('#nama_kepsek').val(responsdata.nama_kepsek);
                    $('#img_foto_kepsek').attr('src', baseurl + 'assets/img/foto/' + responsdata.foto_kepsek);
                    $('#foto_kepsek_lama').val(responsdata.foto_kepsek);
                    $('#img_logo').attr('src', baseurl + 'assets/img/icon/' + responsdata.logo);
                    $('#logo_lama').val(responsdata.logo);
                    $('#img_kop_surat_image').attr('src', baseurl + 'assets/img/gambar/' + responsdata.kop_surat_image);
                    $('#kop_surat_image_lama').val(responsdata.kop_surat_image);
                    $('#facebook').val(responsdata.facebook);
                    $('#twitter').val(responsdata.twitter);
                    $('#youtube').val(responsdata.youtube);
                    $('#instagram').val(responsdata.instagram);
                    $('#motto').val(responsdata.motto);
                    CKEDITOR.instances['sambutan_kepala_sekolah'].setData(responsdata.sambutan_kepala_sekolah);

                }
            })
        }

        $('#simpan').on('click', function (e) {
            e.preventDefault();
            // ambil data dari elemen html
            const nama_sekolah = $('#nama_sekolah').val();
            const jalan = $('#jalan').val();
            const rt = $('#rt').val();
            const rw = $('#rw').val();
            const kelurahan = $('#kelurahan').val();
            const kecamatan = $('#kecamatan').val();
            const kabupaten_kota = $('#kabupaten_kota').val();
            const provinsi = $('#provinsi').val();
            const kode_pos = $('#kode_pos').val();
            const website = $('#website').val();
            const email = $('#email').val();
            const telp = $('#telp').val();
            const nama_kepsek = $('#nama_kepsek').val();
            const foto_kepsek = $('#foto_kepsek').prop('files')[0];
            const foto_kepsek_lama = $('#foto_kepsek_lama').val();
            const logo = $('#logo').prop('files')[0];
            const logo_lama = $('#logo_lama').val();
            const kop_surat_image = $('#kop_surat_image').prop('files')[0];
            const kop_surat_image_lama = $('#kop_surat_image_lama').val();
            const facebook = $('#facebook').val();
            const twitter = $('#twitter').val();
            const youtube = $('#youtube').val();
            const instagram = $('#instagram').val();
            const motto = $('#motto').val();
            const sambutan_kepala_sekolah = CKEDITOR.instances['sambutan_kepala_sekolah'].getData();

            // simpan data dalam bentuk object dengan nama data
            var data = new FormData();
            data.append('nama_sekolah', nama_sekolah);
            data.append('jalan', jalan);
            data.append('rt', rt);
            data.append('rw', rw);
            data.append('kelurahan', kelurahan);
            data.append('kecamatan', kecamatan);
            data.append('kabupaten_kota', kabupaten_kota);
            data.append('provinsi', provinsi);
            data.append('kode_pos', kode_pos);
            data.append('website', website);
            data.append('email', email);
            data.append('telp', telp);
            data.append('nama_kepsek', nama_kepsek);
            data.append('foto_kepsek', foto_kepsek);
            data.append('foto_kepsek_lama', foto_kepsek_lama);
            data.append('logo', logo);
            data.append('logo_lama', logo_lama);
            data.append('kop_surat_image', kop_surat_image);
            data.append('kop_surat_image_lama', kop_surat_image_lama);
            data.append('facebook', facebook);
            data.append('twitter', twitter);
            data.append('youtube', youtube);
            data.append('instagram', instagram);
            data.append('motto', motto);
            data.append('sambutan_kepala_sekolah', sambutan_kepala_sekolah);

            //jalankan ajax
            $.ajax({
                //Alamat url harap disesuaikan dengan lokasi script pada komputer anda
                url: 'admin/pengaturan/ubah',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'JSON',
                success: function (responsdata) {
                    alertData(responsdata.status, responsdata.title, responsdata.pesan);
                    $('#foto_kepsek').val(null);
                    $('#logo').val(null);
                    $('#kop_surat_image').val(null);
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_foto_kepsek').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_logo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_kop_surat_image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#foto_kepsek').change(function () {
            readURL(this);
        });
        $('#logo').change(function () {
            readURL1(this);
        });
        $('#kop_surat_image').change(function () {
            readURL2(this);
        });

        query();

    });
});