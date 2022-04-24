<!-- Modal -->
<div class="modal fade" id="modalPengguna" tabindex="-1" role="dialog" aria-labelledby="modalPenggunaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalPenggunaLabel">Judul Modal</h5>
        <button type="button" class="close batal-pengguna" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="" method="post" enctype="multipart/form-data" id="form-pengguna">            
            <div class="form-group">
                <label for="id_pengguna">ID </label>
                <input type="hidden" id="id_pengguna_lama" name="id_pengguna_lama" class="form-control">
                <input type="text" id="id_pengguna" name="id_pengguna" class="form-control" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="nama_pengguna">Nama <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="nama_pengguna" name="nama_pengguna" class="form-control">
            </div>
            <div class="form-group">
                <label for="username">Username <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="username" name="username" class="form-control">
                <input type="hidden" id="username_lama" name="username_lama" class="form-control">
            </div>
            <div class="form-group">
                <label for="status_pengguna">Status</label>
                <select id="status_pengguna" name="status_pengguna" class="form-control">
                    <option value="Guru">Guru</option>
                    <option value="Staf">Staf</option>
                    <option value="Siswa">Siswa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select id="level" name="level" class="form-control">
                    <option value="Administrator">Administrator</option>
                    <option value="Operator">Operator</option>
                    <option value="Teller">Teller</option>
                </select>
            </div>                  
            <div class="form-group">
                <label for="foto_pengguna">Foto</label><br>
                <div class="foto-prev">
                  <img src="" alt="" style="height: 80px;" id="img_foto_pengguna">
                </div>
                <input type="hidden" id="foto_pengguna_lama" name="foto_pengguna_lama">
                <input type="file" id="foto_pengguna" name="foto_pengguna" class="form-control">
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-pengguna" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-modalPengguna">Simpan</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalDetailPengguna" tabindex="-1" role="dialog" aria-labelledby="modalDetailPenggunaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalDetailPenggunaLabel">Judul Modal</h5>
        <button type="button" class="close batal-detail-pengguna" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-lg-4"></div>
          <div class="col-lg-4 text-center shadow-sm mt-2">
            <img src="" height="100" alt="" id="img_foto_pengguna2" class="rounded">
            <h5 id="head_nama_pengguna2" ></h5>
          </div>
          <div class="col-lg-4"></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>ID :</strong></div>
          <div class="col-lg-6"><p id="id_pengguna2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Nama :</strong></div>
          <div class="col-lg-6"><p id="nama_pengguna2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Username :</strong></div>
          <div class="col-lg-6"><p id="username2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Status :</strong></div>
          <div class="col-lg-6"><p id="status_pengguna2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Level :</strong></div>
          <div class="col-lg-6"><p id="level2"></p></div>
        </div>
        <div class="row">
          <div class="col-lg-6 text-right"><strong>Terakhir Login :</strong></div>
          <div class="col-lg-6"><p id="tgl_login2"></p></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-detail-pengguna" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

