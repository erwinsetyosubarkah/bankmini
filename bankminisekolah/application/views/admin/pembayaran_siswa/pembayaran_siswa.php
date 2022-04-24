



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
                        <a href="" class="btn btn-success" data-toggle="modal" data-target="#modalPembayaranSiswa"  id="btn-tambahModal"><i class="fas fa-fw fa-plus-circle"></i> Tambah Pembayaran Siswa</a>
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalCekHariIni"  id="btn-cekHariIniModal"><i class="fas fa-fw fa-table"></i> Cek Hari Ini</a>
                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modalCekSemuaPembayaran"  id="btn-cekSemuaPembayaranModal"><i class="fas fa-fw fa-table"></i> Cek Semua Pembayaran</a>
                        <a href="" class="btn btn-warning" data-toggle="modal" data-target="#modalExportPembayaranSiswaPerTanggal"  id="btn-exportPembayaranSiswaPerTanggalModal"><i class="fas fa-fw fa-calendar"></i> Export Per Tanggal</a>
                      </div>                    
                  </div>               
                </div>
                <div class="card-body overflow-scroll"> 
                
                    <div class="table-responsive">
                      <table class="table table-bordered nowrap" id="dataTable">
                        <thead>
                          <tr class="text-center bg-info text-white">
                              <th style="width: 50px;">No</th>
                              <th>ID Pembayaran</th>
                              <th>Nama Nasabah</th>
                              <th>ID Nasabah</th>
                              <th>Kelas</th>
                              <th>Jenis Setoran</th>
                              <th>Tanggal Transaksi</th>                              
                              <th>Jumlah Pembayaran</th>                            
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
        <?php include "modal_pembayaran_siswa.php"; ?>

        <script type="text/javascript" src="<?=base_url('assets/js/pembayaran_siswa/pembayaran_siswa.js')?>"></script>
     

     

 