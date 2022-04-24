<!-- Modal -->
<div class="modal fade" id="modalJenisSetoran" tabindex="-1" role="dialog" aria-labelledby="modalJenisSetoranLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalJenisSetoranLabel">Judul Modal</h5>
        <button type="button" class="close batal-jenis-setoran" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="" method="post" enctype="multipart/form-data" id="form-jenis-setoran">            
            <div class="form-group">
                <label for="id_jenis_setoran">ID <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="id_jenis_setoran" name="id_jenis_setoran" class="form-control" disabled="disabled">
            </div>         
            <div class="form-group">
                <label for="jenis_setoran">Jenis Tanda Pengenal <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="jenis_setoran" name="jenis_setoran" class="form-control">
            </div>        
      
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-jenis-setoran" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-modalJenisSetoran">Simpan</button>
      </div>
    </div>
  </div>
</div>


