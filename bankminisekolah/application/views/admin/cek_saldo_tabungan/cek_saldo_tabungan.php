



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
                  
                  <h3>Saldo Keseluruhan Tabungan Siswa di Aplikasi Bank Mini</h3>
                  <h3 class="mb-4"> Sampai Dengan Tanggal <?= $tanggal_sekarang; ?></h3>
                  
                  <h5>Total Setoran Tabungan : Rp. <span class="text-primary"><?= number_format($total_setoran_masuk,0,',','.'); ?></span> </h5>
                  <h5>Total Penarikan Tabungan : Rp. <span class="text-danger"><?= number_format($total_penarikan_tabungan,0,',','.'); ?></span> </h5>
                  <h5>Total Tabungan Yang Tersimpan : Rp. <span class="text-success"><?= number_format($total_setoran_masuk - $total_penarikan_tabungan,0,',','.'); ?></span></h5>

                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

     

     

 