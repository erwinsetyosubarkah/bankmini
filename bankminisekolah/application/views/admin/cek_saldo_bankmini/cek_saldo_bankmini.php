



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
                  
                  <h3>Saldo Keseluruhan di Aplikasi Bank Mini</h3>
                  <h3 class="mb-4"> Sampai Dengan Tanggal <?= $tanggal_sekarang; ?></h3>
                  
                  <h5>Total Pembayaran Siswa : Rp. <span class="text-primary"><?= number_format($total_pembayaran_siswa,0,',','.'); ?></span> </h5>
                  <h5>Total Penarikan Saldo : Rp. <span class="text-danger"><?= number_format($total_penarikan_saldo,0,',','.'); ?></span> </h5>
                  <h5>Total Saldo Bank Mini : Rp. <span class="text-success"><?= number_format($total_pembayaran_siswa - $total_penarikan_saldo,0,',','.'); ?></span></h5>

                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
        
            
        
       

     

     

 