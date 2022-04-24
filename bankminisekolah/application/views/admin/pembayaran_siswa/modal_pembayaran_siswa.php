<!-- Modal -->
<div class="modal fade" id="modalPembayaranSiswa" tabindex="-1" role="dialog" aria-labelledby="modalPembayaranSiswaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalPembayaranSiswaLabel">Judul Modal</h5>
        <button type="button" class="close batal-pembayaran-siswa" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="" method="post" enctype="multipart/form-data" id="form-pembayaran-siswa">            
            <div class="form-group">
                <label for="id_pembayaran_siswa">ID Pembayaran </label>
                <input type="text" id="id_pembayaran_siswa" name="id_pembayaran_siswa" class="form-control" readonly="readonly">
            </div>
            <div class="form-group">
                <label for="tanggal_transaksi_pembayaran_siswa">Tanggal Transaksi</label>
                <input type="date" id="tanggal_transaksi_pembayaran_siswa" name="tanggal_transaksi_pembayaran_siswa" class="form-control">
                <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">Input dengan format mm/dd/yyy</sup>
            </div>
            <div class="form-group">
                <label for="nama_nasabah">ID Nasabah</label>
                <select class="form-control js-example-basic-single select2-dropdown" name="id_nasabah" id="id_nasabah" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option value="">-- Pilih ID Nasabah --</option>
                </select>
                <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">Wajib Diisi</sup>
            </div>
            <div class="form-group">
                <label for="nama_nasabah">Nama Nasabah</label>
                <input type="text" id="nama_nasabah" name="nama_nasabah" class="form-control" readonly="readonly">
            </div>           
            <div class="form-group">
                <label for="id_jenis_setoran">Jenis Setoran</label>
                <select class="form-control" name="id_jenis_setoran" id="id_jenis_setoran">                  
                </select>
            </div>        
            <div class="form-group">
                <label for="jumlah_pembayaran_siswa">Jumlah Pembayaran</label>
                <input type="text" id="jumlah_pembayaran_siswa" name="jumlah_pembayaran_siswa" class="form-control" placeholder="Jumlah yang di bayarkan Rp.">
                <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">Input dengan format angka Ex : 2000</sup>
            </div>  
            <div class="form-group">
                <label for="no_tanda_pengenal_nasabah">No Pengenal</label>
                <input type="text" id="no_tanda_pengenal_nasabah" name="no_tanda_pengenal_nasabah" class="form-control" readonly="readonly">
            </div>         
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" id="kelas" name="kelas" class="form-control" readonly="readonly">
            </div>         
            <div class="form-group">
                <label for="alamat_nasabah">Alamat</label>
                <textarea id="alamat_nasabah" name="alamat_nasabah" class="form-control" readonly="readonly"></textarea>
            </div>  
            <div class="form-group">
                <label for="id_pengguna">Petugas</label>
                <select class="form-control" name="id_pengguna" id="id_pengguna" readonly="readonly">
                  <option value="<?= $this->session->userdata('user')['id_pengguna']; ?>"><?= $this->session->userdata('user')['nama_pengguna']; ?></option>
                </select>
            </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-pembayaran-siswa" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-modalPembayaranSiswa">Simpan</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalDetailPembayaranSiswa" tabindex="-1" role="dialog" aria-labelledby="modalDetailPembayaranSiswaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalDetailPembayaranSiswaLabel">Judul Modal</h5>
        <button type="button" class="close batal-detail-pembayaran-siswa" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">       
        <div class="row">
          <div class="col-lg-6 text-right"><strong>ID Pembayaran :</strong></div>
          <div class="col-lg-6"><p id="id_pembayaran_siswa2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Tanggal Transaksi :</strong></div>
          <div class="col-lg-6"><p id="tanggal_transaksi_pembayaran_siswa2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>ID Nasabah :</strong></div>
          <div class="col-lg-6"><p id="id_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Nama Nasabah :</strong></div>
          <div class="col-lg-6"><p id="nama_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Jenis Setoran :</strong></div>
          <div class="col-lg-6"><p id="jenis_setoran2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Jumlah Bayar :</strong></div>
          <div class="col-lg-6"><p id="jumlah_pembayaran_siswa2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>No Pengenal :</strong></div>
          <div class="col-lg-6"><p id="no_tanda_pengenal_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Kelas :</strong></div>
          <div class="col-lg-6"><p id="kelas2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Alamat :</strong></div>
          <div class="col-lg-6"><p id="alamat_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Petugas :</strong></div>
          <div class="col-lg-6"><p id="nama_pengguna2"></p></div>
        </div>
        
      </div>
      <div class="modal-footer">
        <form action="cetak-bukti-pembayaran-siswa" method="post" target="_blank">
          <input type="hidden" id="id_pembayaran_siswa_cetak" name="id_pembayaran_siswa">
          <button type="submit" class="btn btn-primary btn-cetakBukti"><i class="fas fa-fw fa-print"></i>Cetak Bukti</button>
        </form>
        <button type="button" class="btn btn-secondary batal-detail-pembayaran-siswa" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Cek Hari ini-->
<div class="modal fade" id="modalCekHariIni" tabindex="-1" role="dialog" aria-labelledby="modalCekHariIniLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalCekHariIniLabel">Judul Modal</h5>
        <button type="button" class="close batal-cek-hari-ini" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">       
        <div class="row">
          <div class="col-md-6">
            <form action="cetak-chi-pembayaran-siswa" method="post" target="_blank">
              <button type="submit" class="btn btn-danger btn-cetakCekHariIni"><i class="fas fa-fw fa-print"></i>Cetak</button>
            </form>
          </div>
          <div class="col-md-6">
            <form action="export-chi-pembayaran-siswa" method="post" target="_blank">
              <button type="submit" class="btn btn-primary btn-exportCekHariIni"><i class="fas fa-fw fa-file-excel"></i>Export</button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<!-- Modal Cek Semua Pembayaran-->
<div class="modal fade" id="modalCekSemuaPembayaran" tabindex="-1" role="dialog" aria-labelledby="modalCekSemuaPembayaranLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalCekSemuaPembayaranLabel">Judul Modal</h5>
        <button type="button" class="close batal-cek-semua-pembayaran" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">       
        <div class="row">
          <div class="col-md-6">
            <form action="cetak-css-pembayaran-siswa" method="post" target="_blank">
              <button type="submit" class="btn btn-danger btn-cetakCekSemuaPembayaran"><i class="fas fa-fw fa-print"></i>Cetak</button>
            </form>
          </div>
          <div class="col-md-6">
            <form action="export-css-pembayaran-siswa" method="post" target="_blank">
              <button type="submit" class="btn btn-primary btn-exportCekSemuaPembayaran"><i class="fas fa-fw fa-file-excel"></i>Export</button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>


<!-- Modal Export Per Tanggal-->
<div class="modal fade" id="modalExportPembayaranSiswaPerTanggal" tabindex="-1" role="dialog" aria-labelledby="modalExportPembayaranSiswaPerTanggalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalExportPembayaranSiswaPerTanggalLabel">Judul Modal</h5>
        <button type="button" class="close batal-export-per-tangal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">       
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <form action="export-pembayaran-siswa-per-tanggal" method="post" target="_blank" class="form-group">
                <label for="mulai_tanggal">Mulai Tanggal</label>
                <input type="date" id="mulai_tanggal" name="mulai_tanggal" class="form-control mb-3">
                <label for="sampai_tanggal">Sampai Tanggal</label>
                <input type="date" id="sampai_tanggal" name="sampai_tanggal" class="form-control mb-3">
                <button type="submit" class="btn btn-primary btn-exportPerTanggal"><i class="fas fa-fw fa-file-excel"></i>Export</button>
              </form>
            </div>
          
        </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
