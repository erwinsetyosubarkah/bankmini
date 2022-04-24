



        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">                  
                  <a href="" class="btn btn-success" data-toggle="modal" data-target="#modalKelas"  id="btn-tambahModal"><i class="fas fa-fw fa-plus-circle"></i> Tambah Kelas</a>               
                </div>
                <div class="card-body overflow-scroll"> 
                  
                   
                    <div class="table-responsive">
                      <table class="table table-bordered nowrap" id="dataTable">
                        <thead>
                          <tr class="text-center bg-info text-white">
                              <th style="width: 50px;">No</th>
                              <th>ID Kelas</th>                                                         
                              <th>Jurusan</th>                                                         
                              <th>Tingkat</th>                                                         
                              <th>Kelas</th>                                                         
                              <th>Rombel</th>                                                         
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
        <?php include "modal_kelas.php"; ?>

        <script type="text/javascript" src="<?=base_url('assets/js/kelas/kelas.js')?>"></script>
     

     

 