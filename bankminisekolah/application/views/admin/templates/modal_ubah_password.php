<!-- Modal -->
<div class="modal fade" id="modalUbahPassword" tabindex="-1" role="dialog" aria-labelledby="modalUbahPasswordLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalUbahPasswordLabel">Ubah Password</h5>
        <button type="button" class="close batal-ubah-password" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="" method="post" enctype="multipart/form-data" id="form-ubah-password">            
            <div class="form-group">
                <label for="password_baru">Password Baru <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="password" id="password_baru" name="password_baru" class="form-control">
            </div>
            <div class="form-group">
                <label for="confirm_password_baru">Tulis Ulang Password Baru <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="password" id="confirm_password_baru" name="confirm_password_baru" class="form-control">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-ubah-password" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-modalUbahPassword">Simpan</button>
      </div>
    </div>
  </div>
</div>