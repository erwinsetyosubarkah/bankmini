<!-- Modal -->
<div class="modal fade" id="modalJurusan" tabindex="-1" role="dialog" aria-labelledby="modalJurusanLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalJurusanLabel">Judul Modal</h5>
        <button type="button" class="close batal-jurusan" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="" method="post" enctype="multipart/form-data" id="form-jurusan">            
            <div class="form-group">
                <label for="id_jurusan">ID <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="id_jurusan" name="id_jurusan" class="form-control" disabled="disabled">
            </div>         
            <div class="form-group">
                <label for="jurusan">Jurusan <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="jurusan" name="jurusan" class="form-control">
            </div>         
            <div class="form-group">
                <label for="kode_jurusan">Kode Jurusan <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="kode_jurusan" name="kode_jurusan" class="form-control">
            </div>         
      
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-jurusan" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-modalJurusan">Simpan</button>
      </div>
    </div>
  </div>
</div>


