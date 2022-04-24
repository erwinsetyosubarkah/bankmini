<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua Rekap Tabungan</title>
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
                        <h5 class="border pt-2 pl-2 pr-2 pb-2">Laporan Semua Rekap Tabungan</h5>
                    </th>
                </tr>
            </table>
            <hr class="mb-4">
            <table class="table-bordered mb-4" width="100%" style="padding-left: 5px; padding-right: 5px;">

                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal Transaksi</th>
                    <th class="text-center">ID Nasabah</th>
                    <th class="text-center">No Pengenal/NIS</th>
                    <th class="text-center">Nama Nasabah</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Jumlah_Setoran</th>
                    <th class="text-center">Jumlah Penarikan</th>
                </tr>
                <?php $nourut = 1; ?>
                <?php foreach($data_rekap_tabungan as $drt): ?>
                    <tr>
                       <td class="text-center"><?= $nourut; ?></td>
                       <td class="text-center"><?= tanggal_indonesia($drt->tanggal_transaksi_tabungan); ?></td>
                       <td class="text-center"><?= $drt->id_nasabah; ?></td>
                       <td class="text-center"><?= $drt->no_tanda_pengenal_nasabah; ?></td>
                       <td>&nbsp;<?= $drt->nama_nasabah; ?></td>
                       <td class="text-center"><?= $drt->tingkat; ?> <?= $drt->kode_jurusan; ?> <?= $drt->rombel; ?></td>
                       <td class="text-center">Rp. <?= number_format($drt->jumlah_setoran_masuk,0,',','.'); ?></td>
                       <td class="text-center">Rp. <?= number_format($drt->jumlah_penarikan_tabungan,0,',','.'); ?></td>
                       
                    </tr>
                    <?php $nourut++; ?>
                <?php endforeach; ?>
                <tr>
                    <th class="text-center" colspan="6">Total Setoran Masuk</th>
                    
                    <th class="text-center" colspan="2">Rp. <?= number_format($total_setoran_masuk,0,',','.'); ?></th>
                    
                </tr>
                <tr>
                    <th class="text-center" colspan="6">Total Penarikan Tabungan</th>
                    
                    <th class="text-center" colspan="2">Rp. <?= number_format($total_penarikan_tabungan,0,',','.'); ?></th>

                </tr>
                <tr>
                    <th class="text-center" colspan="6">Sisa Saldo Tabungan</th>
                    
                    <th class="text-center" colspan="2">Rp. <?= number_format($total_setoran_masuk - $total_penarikan_tabungan,0,',','.'); ?></th>
                    
                </tr>
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