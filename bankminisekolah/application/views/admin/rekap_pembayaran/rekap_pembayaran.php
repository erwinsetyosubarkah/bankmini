



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
                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modalCekRekapPembayaran"  id="btn-cekRekapPembayaranModal"><i class="fas fa-fw fa-table"></i> Cek Rekap Pembayaran</a>
                        <a href="" class="btn btn-warning" data-toggle="modal" data-target="#modalExportRekapPembayaranPerTanggal"  id="btn-exportRekapPembayaranPerTanggalModal"><i class="fas fa-fw fa-calendar"></i> Export Per Tanggal</a>
                      </div>                    
                  </div>               
                </div>
                <div class="card-body overflow-scroll"> 
                
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

        <!-- modal  -->
        <?php include "modal_rekap_pembayaran.php"; ?>

        <script type="text/javascript" src="<?=base_url('assets/js/rekap_pembayaran/rekap_pembayaran.js')?>"></script>
     

     

 