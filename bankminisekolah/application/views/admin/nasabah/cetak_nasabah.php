<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Nasabah</title>
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
                        <h5 class="border pt-2 pl-2 pr-2 pb-2">Data Nasabah</h5>
                        <h6><?= $tanggal_hari_ini; ?></h5>
                    </th>
                </tr>
            </table>
            <hr class="mb-4">
            <table class="table-bordered mb-4" width="100%" style="padding-left: 5px; padding-right: 5px;">

                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID Nasabah</th>
                    <th class="text-center">Nama Nasabah</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Tempat Tanggal Lahir</th>
                    <th class="text-center">No Telp</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Saldo</th>
                </tr>
                <?php $nourut = 1; ?>
                <?php foreach($data_nasabah as $dtnsb): ?>
                    <tr>
                       <td class="text-center"><?= $nourut; ?></td>
                       <td class="text-center"><?= $dtnsb->id_nasabah; ?></td>
                       <td class="text-center"><?= $dtnsb->nama_nasabah; ?></td>
                       <td class="text-center"><?= $dtnsb->jenis_kelamin_nasabah; ?></td>
                       <td class="text-center"><?= $dtnsb->tempat_lahir_nasabah.", ".tanggal_indonesia($dtnsb->tanggal_lahir_nasabah); ?></td>
                       <td>&nbsp;<?= $dtnsb->no_telp_nasabah; ?></td>
                       <td class="text-center"><?= $dtnsb->tingkat; ?> <?= $dtnsb->kode_jurusan; ?> <?= $dtnsb->rombel; ?></td>
                       <td class="text-center">Rp. <?= number_format($dtnsb->saldo_nasabah,0,',','.'); ?></td>
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