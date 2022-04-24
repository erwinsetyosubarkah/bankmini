

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
                  
                 <div class="row mb-4">
                   <div class="col-md-4"></div>
                   <div class="col-md-4 text-center">
                   <img class="img-profile shadow-lg" src="<?= base_url(); ?>assets/img/foto/<?= $_SESSION['user']['foto_pengguna']; ?>" height="200" width="200">
                   </div>
                   <div class="col-md-4"></div>
                 </div>
                 <div class="row">
                   <div class="col-md-3"></div>
                   <div class="col-md-6 form-group">
                     <label for='id_pengguna'>ID Pengguna </label>
                     <input type='text' name='id_pengguna' id='id_pengguna' readonly="readonly" class="form-control mb-4" value="<?= $_SESSION['user']['id_pengguna']; ?>">
                     <label for='nama_pengguna'>Nama </label>
                     <input type='text' name='nama_pengguna' id='nama_pengguna' readonly="readonly" class="form-control mb-4" value="<?= $_SESSION['user']['nama_pengguna']; ?>">
                     <label for='username'>Username </label>
                     <input type='text' name='username' id='username' readonly="readonly" class="form-control mb-4" value="<?= $_SESSION['user']['username']; ?>">
                     <label for='status_pengguna'>Status </label>
                     <input type='text' name='status_pengguna' id='status_pengguna' readonly="readonly" class="form-control mb-4" value="<?= $_SESSION['user']['status_pengguna']; ?>">
                     <label for='level'>Level </label>
                     <input type='text' name='level' id='level' readonly="readonly" class="form-control mb-4" value="<?= $_SESSION['user']['level']; ?>">
                     <label for='tgl_login'>Terakhir Login </label>
                     <input type='text' name='tgl_login' id='tgl_login' readonly="readonly" class="form-control mb-4" value="<?= $_SESSION['user']['tgl_login']; ?>">
                     
                   </div>
                   <div class="col-md-3"></div>
                 </div>

                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

     

     

 