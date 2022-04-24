



        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">                  
                 
                </div>
                <div class="card-body overflow-scroll"> 
                  <form action="" method="post" enctype="multipart/form-data" id="form-cek-saldo-nasabah" class="mb-4">
                      <div class="form-group">
                          <label for="id_nasabah">ID Nasabah</label>
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
                          <label for="saldo_nasabah">Saldo Nasabah</label>
                          <input type="text" id="saldo_nasabah" name="saldo_nasabah" class="form-control" readonly="readonly">
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
                      <button type="button" id="clearForm" class="btn btn-secondary">Bersihkan</button>
                      <a href="#" class="btn btn-primary" id="btn-cetak"><i class="fas fa-fw fa-print"></i> Cetak</a>
                      <a href="#" class="btn btn-success" id="btn-export"><i class="fas fa-fw fa-print"></i> Export</a>
                  </form>

                    <div class="table-responsive">
                      <table class="table table-bordered nowrap" id="dataTable">
                        <thead>
                          <tr class="text-center bg-info text-white">
                              <th style="width: 50px;">No</th>
                              <th>Tanggal Transaksi</th>                              
                              <th>ID Nasabah</th>
                              <th>No Pengenal/NIS</th>
                              <th>Nama Nasabah</th>
                              <th>Kelas</th>
                              <th>Jumlah Setoran</th>                            
                              <th>Jumlah Penarikan</th>  
                          </tr>
                        </thead>
                        
                      </table>
                    </div>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->


        
        <script type="text/javascript" src="<?=base_url('assets/js/cek_saldo_nasabah/cek_saldo_nasabah.js')?>"></script>
     

     

 