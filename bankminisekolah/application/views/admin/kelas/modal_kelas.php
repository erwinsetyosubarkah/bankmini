<!-- Modal -->
<div class="modal fade" id="modalKelas" tabindex="-1" role="dialog" aria-labelledby="modalKelasLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalKelasLabel">Judul Modal</h5>
        <button type="button" class="close batal-kelas" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="" method="post" enctype="multipart/form-data" id="form-kelas">            
            <div class="form-group">
                <label for="id_kelas">ID <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="id_kelas" name="id_kelas" class="form-control" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="id_jurusan">Jurusan</label>
                <select id="id_jurusan" name="id_jurusan" class="form-control">
                </select>
            </div>  
            <div class="form-group">
                <label for="tingkat">Tingkat</label>
                <select id="tingkat" name="tingkat" class="form-control">
                  <option value="X">X</option>
                  <option value="XI">XI</option>
                  <option value="XII">XII</option>
                </select>
            </div>  
            <div class="form-group">
                <label for="rombel">Rombel <span class="text-danger">*</span><sup style="color: red; font-size: 9px;">wajib diisi</sup></label>
                <input type="text" id="rombel" name="rombel" class="form-control">
            </div>         
      
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary batal-kelas" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-modalKelas">Simpan</button>
      </div>
    </div>
  </div>
</div>


