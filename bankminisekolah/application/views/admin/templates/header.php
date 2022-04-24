<!DOCTYPE html>
<?php date_default_timezone_set('Asia/Jakarta'); ?>
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
  <link rel="stylesheet" type="text/css" href="<?= base_url("assets/"); ?>/nunito-webfont/style.css"/>

  <!-- Custom styles for this template-->
  <link href="<?= base_url("assets/"); ?>sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="<?= base_url("assets/"); ?>sbadmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <link href="<?= base_url("assets/"); ?>css/custom_admin.css" rel="stylesheet">

  <!-- Select2 -->
  <link href="<?= base_url("assets/"); ?>select2/css/select2.min.css" rel="stylesheet" />
  <link href="<?= base_url("assets/"); ?>select2/css/select2-bootstrap4.min.css" rel="stylesheet" />

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

    function alertConfirm(status,title,pesan,textBtn,callback){
      
      Swal.fire({
          title: title,
          text: pesan,
          icon: status,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: textBtn,
          cancelButtonText : 'Batal',
        }).then((confirmed) => {
          
            callback(confirmed && confirmed.value == true);
          
        })
    }
  </script>

</head>

<body id="page-top">
  <!-- variable base url untuk javascript -->
  <input type="hidden" value="<?= base_url(); ?>" id="baseurl">

  <!-- Page Wrapper -->
  <div id="wrapper">

      <!-- include halaman sidebar -->
      <?php include "sidebar.php" ?>
      <!-- akhir include halaman sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <!-- include halaman topbar -->
          <?php include "topbar.php" ?>
          <!-- akhirinclude halaman topbar -->       
              
          