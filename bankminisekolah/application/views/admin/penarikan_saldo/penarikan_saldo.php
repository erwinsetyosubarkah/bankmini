



        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">                  
                  <div class="row">
                      <div class="col-lg-12">                   
                        <a href="" class="btn btn-success" data-toggle="modal" data-target="#modalPenarikanSaldo"  id="btn-tambahModal"><i class="fas fa-fw fa-plus-circle"></i> Tambah Penarikan Saldo</a>
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalCekHariIni"  id="btn-cekHariIniModal"><i class="fas fa-fw fa-table"></i> Cek Hari Ini</a>
                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modalCekSemuaPenarikan"  id="btn-cekSemuaPenarikanModal"><i class="fas fa-fw fa-table"></i> Cek Semua Penarikan</a>
                        <a href="" class="btn btn-warning" data-toggle="modal" data-target="#modalExportPenarikanSaldoPerTanggal"  id="btn-exportPenarikanSaldoPerTanggalModal"><i class="fas fa-fw fa-calendar"></i> Export Per Tanggal</a>
                      </div>                    
                  </div>               
                </div>
                <div class="card-body overflow-scroll"> 
                
                    <div class="table-responsive">
                      <table class="table table-bordered nowrap" id="dataTable">
                        <thead>
                          <tr class="text-center bg-info text-white">
                              <th style="width: 50px;">No</th>
                              <th>ID Penarikan</th>
                              <th>Nama Penarik</th>
                              <th>Tanggal Penarikan</th>                              
                              <th>Keterangan Penarikan</th>
                              <th>Jumlah Penarikan</th>                            
                              <th style="width: 150px;">Aksi</th>
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


        <!-- modal  -->
        <?php include "modal_penarikan_saldo.php"; ?>

        <script type="text/javascript" src="<?=base_url('assets/js/penarikan_saldo/penarikan_saldo.js')?>"></script>
     

     

 