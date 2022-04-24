
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary"> 

                </div>                
                <div class="card-body">
                  <!-- Content Row -->
                  <div class="row">
                    <!-- Rombel Card Example -->
                    <div class=" col-md-12">
                      <h2>Selamat Datang <span class="text-danger"><?= $_SESSION['user']['nama_pengguna'] ?></span> di APLIKASI BANK MINI SEKOLAH</h2>
                      <h4><?php echo tanggal_indonesia_lengkap($this->tanggal); ?></h4>
                    </div>
                  </div>
                </div>
              </div>


              <!-- Approach2 -->
              <div class="card shadow mb-4">
                              
                <div class="card-body">
                  <h4><span class="text-success"><i class="fas fa-dollar-sign"></i> Transaksi Bank Mini Hari</span> <?php echo nama_hari($this->hari); ?></h4>
                  <!-- Content Row1 -->
                  <div class="row">
                  
                    <!-- Jumlah Siswa Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-primary shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tabungan Masuk</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($setoran_masuk_hari_ini,0,',','.'); ?></div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>

                    <!-- Jumlah Guru Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-success shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Penarikan Tabungan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($penarikan_tabungan_hari_ini,0,',','.'); ?></div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>

                    <!-- Jumlah Ekskul Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-info shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pembayaran Siswa</div>
                                <div class="row no-gutters align-items-center">
                                  <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Rp. <?= number_format($pembayaran_siswa_hari_ini,0,',','.'); ?></div>
                                  </div>                                  
                                </div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>

                    <!-- Rombel Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-warning shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tarik Saldo</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($penarikan_saldo_hari_ini,0,',','.'); ?></div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-university fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>


                  <h4><span class="text-primary"><i class="fas fa-dollar-sign"></i>  Transaksi Bank Mini Bulan</span> <?php echo bulan_panjang($this->bulan)." ".$this->tahun; ?></h4>
                  <!-- Content Row3 -->
                  <div class="row">
                  
                    <!-- Jumlah Siswa Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-primary shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tabungan Masuk</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($setoran_masuk_bulan_ini,0,',','.'); ?></div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>

                    <!-- Jumlah Guru Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-success shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Penarikan Tabungan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($penarikan_tabungan_bulan_ini,0,',','.'); ?></div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>

                    <!-- Jumlah Ekskul Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-info shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pembayaran Siswa</div>
                                <div class="row no-gutters align-items-center">
                                  <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Rp. <?= number_format($pembayaran_siswa_bulan_ini,0,',','.'); ?></div>
                                  </div>                                  
                                </div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>

                    <!-- Rombel Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-warning shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tarik Saldo</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($penarikan_saldo_bulan_ini,0,',','.'); ?></div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-university fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-md-12 text-center">
                      <h6 class="font-italic">Statistik Transaksi Bank Mini Di Atas Di Ambil Berdasarkan Jangka Waktu</h6> 
                    </div>
                  </div>
                </div>                 
              </div>

              <!-- Approach3 -->
              <div class="card shadow mb-4">
                              
                <div class="card-body">
                  <h4><span class="text-primary"><i class="fas fa-dollar-sign"></i>  Nasabah Bank Mini Bulan</span> <?php echo bulan_panjang($this->bulan)." ".$this->tahun; ?></h4>
                  <!-- Content Row1 -->
                  <div class="row">
                  
                    <!-- Jumlah Siswa Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#" class="card-link">
                        <div class="card border-left-primary shadow h-100 py-2">
                          <div class="card-body">
                            <div class="row no-gutters align-items-center">
                              <div class="col mr-2">
                                <div class="text-m font-weight-bold text-primary text-uppercase mb-1"><?= $total_nasabah - $total_nasabah_tidak_aktif; ?></div>
                                <div class="text-s font-weight-bold text-gray-800 text-uppercase">Nasabah Aktif Dari <span class="text-primary"><?= $total_nasabah; ?></span> Nasabah</div>
                              </div>
                              <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>

                    <!-- Jumlah Guru Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                     
                    </div>

                    <!-- Jumlah Ekskul Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      
                    </div>

                    <!-- Rombel Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      
                    </div>
                    <div class="col-md-12 text-center">
                      <h6 class="font-italic">Berikut ini adalah tampilan Statistik Data Bank Mini <?= $pengaturan['nama_sekolah']; ?> Hari <?php echo tanggal_indonesia_lengkap($this->tanggal); ?></h6> 
                    </div>
                  </div>
                </div>                 
              </div>
              
            </div>                      
          </div>
          
        </div>
        <!-- /.container-fluid -->

     

        <script type="text/javascript" src="<?=base_url('assets/js/beranda/beranda.js')?>"></script>

 