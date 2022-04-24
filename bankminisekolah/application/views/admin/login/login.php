

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-6">

          
            <div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                  
                  <div class="col-lg-12">
                    <div class="p-5">
                      <div class="text-center">
                        <img src="<?= base_url("assets/"); ?>img/icon/<?= $pengaturan['logo']; ?>" height="130" alt="Logo Sekolah">
                        <h2 class="text-gray-900 mb-0">Bank Mini Sekolah</h2>
                        <hr class="mb-3 mt-0">
                        <h5 class="text-gray-900 mb-0"><?= strtoupper($pengaturan['nama_sekolah']); ?> <?= strtoupper($pengaturan['kabupaten_kota']); ?></h5>
                        
                      </div>
                      <form class="user mt-3" method="post" action="<?= base_url(); ?>login-user">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-user" id="username" name="username"  placeholder="Masukan Username.....">
                          <?= form_error('username','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="form-group">
                          <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                          <?= form_error('password','<small class="text-danger pl-3">','</small>'); ?>
                        </div>                        
                        
                        <button type="submit" class="btn btn-primary btn-user btn-block" id="btn-masuk">
                          Masuk
                        </button>
                        <a href="index.php" class="btn btn-danger btn-user btn-block">
                          Kembali
                        </a>
                        <hr>

                        <center><small><i><?= $pengaturan['jalan'].' Rt. '.$pengaturan['rt'].' Rw. '.$pengaturan['rw'].' Kel. '.$pengaturan['kelurahan'].' Kec. '.$pengaturan['kecamatan'].' '.$pengaturan['kabupaten_kota'].' - '.$pengaturan['provinsi']; ?></i></small><br>
                        <small><a href="<?= $pengaturan['website']; ?>"><?= $pengaturan['website']; ?></a></small></center>

                      </form>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3"></div>
        </div>

      </div>

    </div>
    
  </div>
  <!-- Footer -->
  <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; 2021 </span><span style="color: red;">&hearts;</span><span> Erwin Setyo Subarkah</span>
          </div>
        </div>
    </footer>
    <!-- End of Footer -->
  <script type="text/javascript" src="<?=base_url('assets/js/login/login.js')?>"></script>
     
