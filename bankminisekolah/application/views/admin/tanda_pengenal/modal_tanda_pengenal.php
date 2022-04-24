<!-- Modal -->
<div class="modal fade" id="modalTandaPengenal" tabindex="-1" role="dialog" aria-labelledby="modalTandaPengenalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalTandaPengenalLabel">Judul Modal</h5>
        <button type="button" class="close batal-tanda-pengenal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="" method="post" enctype="multipart/form-data" id="form-tanda-pengenal">            
            <div class="form-group">
                <label for="id_tanda_pengenal">ID <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="id_tanda_pengenal" name="id_tanda_pengenal" class="form-control" disabled="disabled">
            </div>         
            <div class="form-group">
                <label for="jenis_tanda_pengenal">Jenis Tanda Pengenal <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="jenis_tanda_pengenal" name="jenis_tanda_pengenal" class="form-control">
            </div>        
      
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-tanda-pengenal" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-modalTandaPengenal">Simpan</button>
      </div>
    </div>
  </div>
</div>


