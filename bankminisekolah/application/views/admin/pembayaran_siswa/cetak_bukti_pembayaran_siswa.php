<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Pembayaran Siswa</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?= base_url("assets/"); ?>bootstrap/css/bootstrap.min.css">
                
</head>
<body>
    <div class="container-fluid pt-2 border">
       
            <table class="table table-borderless">
                <tr class="text-center">
                    <th width="250">
                        <img src="<?= base_url("assets/"); ?>img/icon/<?= $pengaturan['logo']; ?>" width="70">
                    </th>
                    <th>
                            <h5 class="mt-0 mb-0">BANK MINI</h5>
                        <h4 class="mt-0 mb-0"><?= $pengaturan['nama_sekolah']; ?></h4>
                        
                        <small>
                            <?= $pengaturan['jalan']; ?> RT. <?= $pengaturan['nama_sekolah']; ?> RW. <?= $pengaturan['nama_sekolah']; ?> Kel. <?= $pengaturan['kelurahan']; ?> Kec. <?= $pengaturan['kecamatan']; ?> <?= $pengaturan['kabupaten_kota']; ?>
                        </small>
                    </th>                  
                    <th width="250">
                        <h5 class="border pt-2 pl-2 pr-2 pb-2">Bukti Pembayaran Siswa</h5>
                    </th>
                </tr>
            </table>
            <hr class="mb-4">
            <table class="table-bordered mb-0" width="100%" style="padding-left: 5px; padding-right: 5px;">
                <tr>
                    <th width="150">&nbsp;ID Pembayaran</th>
                    <td width="400">&nbsp;<?= $data_pembayaran_siswa['id_pembayaran_siswa']; ?></td>
                    <th rowspan="2" colspan="2" class="text-center"> Tanggal: <?= $data_pembayaran_siswa['tanggal_transaksi_pembayaran_siswa']; ?> </th>
                    
                    
                </tr>
                <tr>
                    <th>&nbsp;ID Nasabah</th>
                    <td>&nbsp;<?= $data_pembayaran_siswa['id_nasabah']; ?></td>
                    
                    
                </tr>
                <tr>
                    <th>&nbsp;Nama Nasabah</th>
                    <td>&nbsp;<?= $data_pembayaran_siswa['nama_nasabah']; ?></td>
                    <th width="130">&nbsp;Jenis Setoran</th>
                    <td>&nbsp;<?= $data_pembayaran_siswa['jenis_setoran']; ?></td>
                </tr>
                <tr>
                    <th>&nbsp;Kelas</th>
                    <td>&nbsp;<?= $data_pembayaran_siswa['tingkat']; ?> <?= $data_pembayaran_siswa['kode_jurusan']; ?> <?= $data_pembayaran_siswa['rombel']; ?></td>
                    <th>&nbsp;Jumlah</th>
                    <td>&nbsp;Rp.&nbsp;<?= number_format($data_pembayaran_siswa['jumlah_pembayaran_siswa'],0,",","."); ?></td>
                </tr>     
            </table>
            <table class="table-bordered mt-0 mb-1" width="600px">
                <tr class="text-center">
                    <th height="25px" width="200px">Disahkan :</th>
                    <th width="200px">Teller :</th>
                    <th width="200px">Penyetor :</th>
                </tr>
                <tr class="align-bottom text-center">
                    <td height="100px"></td>
                    <td><?= $data_pembayaran_siswa['nama_pengguna']; ?></td>
                    <td><?= $data_pembayaran_siswa['nama_nasabah']; ?></td>
                </tr>
            </table>
            
        <br>
        <small class="font-italic">Keterangan :</small><br>
        <small class="font-italic">Slip ini sah apabila telah divalidasi dan ditanda tangani petugas Bank Mini</small>
    </div>

   


        <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url("assets/"); ?>bootstrap/js/jquery-3.3.1.slim.min.js"></script>
    <script src="<?= base_url("assets/"); ?>bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url("assets/"); ?>bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

<script>
    window.onafterprint = window.close;
    window.print();
</script>