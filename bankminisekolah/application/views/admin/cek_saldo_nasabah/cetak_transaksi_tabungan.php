<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi Nasabah</title>
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
                        <h5 class="border pt-2 pl-2 pr-2 pb-2">Rekening Koran Nasabah</h5>
                        <h6><?= $tanggal_hari_ini; ?></h5>
                    </th>
                </tr>
            </table>
            <table class="table table-borderless">
                <tr>
                    <th width="150">ID</th>
                    <th>: <?= $data_nasabah['id_nasabah']; ?></th>
                    <th></th>
                    <th width="150">Kelas</th>
                    <th>: <?= $data_nasabah['tingkat']." ".$data_nasabah['kode_jurusan']." ".$data_nasabah['rombel']; ?></th>
                </tr>
                <tr>
                    <th>Nama</th>
                    <th>: <?= $data_nasabah['nama_nasabah']; ?></th>
                    <th></th>
                    <th>Saldo</th>
                    <th>: Rp. <?= number_format($data_nasabah['saldo_nasabah'],0,',','.'); ?></th>
                </tr>
            </table>
            <hr class="mb-4">
            <table class="table-bordered mb-4" width="100%" style="padding-left: 5px; padding-right: 5px;">

                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal Transaksi</th>
                    <th class="text-center">Jumlah Setoran</th>
                    <th class="text-center">Jumlah Penarikan</th>
                </tr>
                <?php $nourut = 1; ?>
                <?php foreach($data_transaksi_tabungan as $dttt): ?>
                    <tr>
                       <td class="text-center"><?= $nourut; ?></td>
                       <td class="text-center"><?= tanggal_indonesia($dttt->tanggal_transaksi_tabungan); ?></td>                       
                       <td class="text-center">Rp. <?= number_format($dttt->jumlah_setoran_masuk,0,',','.'); ?></td>
                       <td class="text-center">Rp. <?= number_format($dttt->jumlah_penarikan_tabungan,0,',','.'); ?></td>
                    </tr>
                    <?php $nourut++; ?>
                <?php endforeach; ?>
               

            </table>
  

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