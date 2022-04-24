<!-- Modal -->
<div class="modal fade" id="modalNasabah" tabindex="-1" role="dialog" aria-labelledby="modalNasabahLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalNasabahLabel">Judul Modal</h5>
        <button type="button" class="close batal-nasabah" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="" method="post" enctype="multipart/form-data" id="form-nasabah">            
            <div class="form-group">
                <label for="id_nasabah">ID </label>
                <input type="text" id="id_nasabah" name="id_nasabah" class="form-control" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="nama_nasabah">Nama <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="nama_nasabah" name="nama_nasabah" class="form-control">
            </div>
            <div class="form-group">
                <label for="jenis_kelamin_nasabah">Jenis Kelamin</label>
                <select id="jenis_kelamin_nasabah" name="jenis_kelamin_nasabah" class="form-control">
                    <option value="Laki-laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tempat_lahir_nasabah">Tempat Lahir</label>
                <input type="text" id="tempat_lahir_nasabah" name="tempat_lahir_nasabah" class="form-control">
            </div>
            <div class="form-group">
                <label for="tanggal_lahir_nasabah">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir_nasabah" name="tanggal_lahir_nasabah" class="form-control">
            </div>
            <div class="form-group">
                <label for="alamat_nasabah">Alamat</label>
                <textarea id="alamat_nasabah" name="alamat_nasabah" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="no_telp_nasabah">No Telp</label>
                <input type="number" id="no_telp_nasabah" name="no_telp_nasabah" class="form-control">
            </div>
            <div class="form-group">
                <label for="id_tanda_pengenal">Jenis Tanda Pengenal</label>
                <select id="id_tanda_pengenal" name="id_tanda_pengenal" class="form-control">
                </select>
            </div> 
            <div class="form-group">
                <label for="no_tanda_pengenal_nasabah">No Tanda Pengenal</label>
                <input type="number" id="no_tanda_pengenal_nasabah" name="no_tanda_pengenal_nasabah" class="form-control">
            </div>
            <div class="form-group">
                <label for="id_kelas">Kelas</label>
                <select id="id_kelas" name="id_kelas" class="form-control">
                </select>
            </div> 
            <input type="hidden" value="0" id="saldo_nasabah" name="saldo_nasabah">

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-nasabah" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-modalNasabah">Simpan</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalDetailNasabah" tabindex="-1" role="dialog" aria-labelledby="modalDetailNasabahLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalDetailNasabahLabel">Judul Modal</h5>
        <button type="button" class="close batal-detail-nasabah" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">       
        <div class="row">
          <div class="col-lg-6 text-right"><strong>ID :</strong></div>
          <div class="col-lg-6"><p id="id_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Nama :</strong></div>
          <div class="col-lg-6"><p id="nama_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Jenis Kelamin :</strong></div>
          <div class="col-lg-6"><p id="jenis_kelamin_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Tempat Lahir :</strong></div>
          <div class="col-lg-6"><p id="tempat_lahir_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Tanggal Lahir :</strong></div>
          <div class="col-lg-6"><p id="tanggal_lahir_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Alamat :</strong></div>
          <div class="col-lg-6"><p id="alamat_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Nomor Telpon :</strong></div>
          <div class="col-lg-6"><p id="no_telp_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Jenis Tanda Pengenal :</strong></div>
          <div class="col-lg-6"><p id="jenis_tanda_pengenal2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>No Tanda Pengenal :</strong></div>
          <div class="col-lg-6"><p id="no_tanda_pengenal_nasabah2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Kelas :</strong></div>
          <div class="col-lg-6"><p id="kelas2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Saldo :</strong></div>
          <div class="col-lg-6"><p id="saldo_nasabah2"></p></div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-detail-nasabah" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

