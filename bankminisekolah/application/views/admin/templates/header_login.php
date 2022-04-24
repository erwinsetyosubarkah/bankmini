<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bank Mini <?= $pengaturan['nama_sekolah']; ?></title>

    <!-- favicon -->
    <link rel="icon" href="<?= base_url("assets/"); ?>img/icon/<?= $pengaturan['logo']; ?>" type="image/x-icon">

  <!-- Custom fonts for this template-->
  <link href="<?= base_url("assets/"); ?>sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url("assets/"); ?>sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Sweet Alert 2 -->
  <script src="<?= base_url("assets/"); ?>sweetalert2/dist/sweetalert2.all.js"></script>

  <script>  
    function alertData(status,title,pesan){
      Swal.fire({
                      icon: status,
                      title: title,
                      text: pesan
                      })
    }

    function alertLoading(){
      Swal.fire({
                title: 'Dalam Proses',
                html: 'Harap Tunggu.....',
                showConfirmButton : false,
                didOpen: () => {
                  Swal.showLoading()
                }
              })
    }
  </script>

</head>

<body class="bg-gradient-primary">
  <!-- variable base url untuk javascript -->
  <input type="hidden" value="<?= base_url(); ?>" id="baseurl">