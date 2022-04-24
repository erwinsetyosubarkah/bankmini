<!-- Modal Cek Rekap Tabungan-->
<div class="modal fade" id="modalCekRekapTabungan" tabindex="-1" role="dialog" aria-labelledby="modalCekRekapTabunganLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalCekRekapTabunganLabel">Judul Modal</h5>
        <button type="button" class="close batal-cek-semua-setoran" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">       
        <div class="row">
          <div class="col-md-6">
            <form action="cetak-css-rekap-tabungan" method="post" target="_blank">
              <button type="submit" class="btn btn-danger btn-cetakCekRekapTabungan"><i class="fas fa-fw fa-print"></i>Cetak</button>
            </form>
          </div>
          <div class="col-md-6">
            <form action="export-css-rekap-tabungan" method="post" target="_blank">
              <button type="submit" class="btn btn-primary btn-exportCekRekapTabungan"><i class="fas fa-fw fa-file-excel"></i>Export</button>
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
<div class="modal fade" id="modalExportRekapTabunganPerTanggal" tabindex="-1" role="dialog" aria-labelledby="modalExportRekapTabunganPerTanggalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalExportRekapTabunganPerTanggalLabel">Judul Modal</h5>
        <button type="button" class="close batal-export-per-tangal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">       
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <form action="export-rekap-tabungan-per-tanggal" method="post" target="_blank" class="form-group">
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