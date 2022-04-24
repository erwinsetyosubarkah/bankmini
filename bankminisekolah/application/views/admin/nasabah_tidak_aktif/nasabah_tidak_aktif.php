



        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">                  
                  <form action="export-nasabah-tidak-aktif" method="post" target="_blank" class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-file-excel"></i>Export Tidak Aktif</button>
                  </form>
                <div class="card-body overflow-scroll"> 
                                     
                    <div class="table-responsive">
                      <table class="table table-bordered nowrap" id="dataTable">
                        <thead>
                          <tr class="text-center bg-info text-white">
                              <th style="width: 50px;">No</th>
                              <th>ID Nasabah</th>
                              <th>No Pengenal/NIS</th>
                              <th>Nama Nasabah</th>
                              <th>Kelas</th>                                                         
                              <th>Jenis Kelamin</th>                                                         
                              <th>Saldo</th>
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



        <script type="text/javascript" src="<?=base_url('assets/js/nasabah_tidak_aktif/nasabah_tidak_aktif.js')?>"></script>
     

     

 