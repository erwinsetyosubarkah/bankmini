



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
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group mb-5">
                                <label for="nama_sekolah">Nama Sekolah : </label>
                                <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control">
                            </div>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Alamat : </legend>
                                <div class="form-group ml-5">
                                    <label for="jalan">Jalan : </label>
                                    <textarea name="jalan" id="jalan" class="form-control"></textarea>
                                </div>
                                <div class="form-group ml-5">
                                    <label for="rt">RT : </label>
                                    <input type="number" name="rt" id="rt" class="form-control">
                                </div>
                                <div class="form-group ml-5">
                                    <label for="rw">RW : </label>
                                    <input type="number" name="rw" id="rw" class="form-control">
                                </div>
                                <div class="form-group ml-5">
                                    <label for="kelurahan">Kelurahan : </label>
                                    <input type="text" name="kelurahan" id="kelurahan" class="form-control">
                                </div>
                                <div class="form-group ml-5">
                                    <label for="kecamatan">Kecamatan : </label>
                                    <input type="text" name="kecamatan" id="kecamatan" class="form-control">
                                </div>
                                <div class="form-group ml-5">
                                    <label for="kabupaten_kota">Kabupaten/Kota : </label>
                                    <input type="text" name="kabupaten_kota" id="kabupaten_kota" class="form-control">
                                </div>
                                <div class="form-group ml-5">
                                    <label for="provinsi">Provinsi : </label>
                                    <input type="text" name="provinsi" id="provinsi" class="form-control">
                                </div>
                                <div class="form-group ml-5">
                                    <label for="kode_pos">Kode Pos : </label>
                                    <input type="text" name="kode_pos" id="kode_pos" class="form-control">
                                </div>
                            </fieldset>
                            <div class="form-group">
                                <label for="website">Website : </label>
                                <input type="url" name="website" id="website" class="form-control" placeholder="https://example.com">
                            </div>
                            <div class="form-group">
                                <label for="email">Email : </label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="example@email.com">
                            </div>
                            <div class="form-group">
                                <label for="telp">No. Telp : </label>
                                <input type="telp" name="telp" id="telp" class="form-control" placeholder="example@email.com">
                            </div>                            
                            <div class="form-group">
                                <label for="nama_kepsek">Nama Kepala Sekolah : </label>
                                <input type="text" name="nama_kepsek" id="nama_kepsek" class="form-control">
                            </div>                            
                        </div>
                        <div class="col-lg-2"></div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="foto_kepsek">Foto Kepala Sekolah : </label><br>
                                <img src="" style="height: 80px;" id="img_foto_kepsek">
                                <input type="hidden" id="foto_kepsek_lama" name="foto_kepsek_lama">
                                <input type="file" name="foto_kepsek" id="foto_kepsek" class="form-control" accept="image/x-png,image/jpg,image/gif,image/jpeg">
                            </div> 
                            <div class="form-group">
                                <label for="logo">Logo Sekolah : </label><br>
                                <img src="" style="height: 80px;" id="img_logo">
                                <input type="hidden" id="logo_lama" name="logo_lama">
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/x-png,image/jpg,image/gif,image/jpeg">
                            </div> 
                            <div class="form-group">
                                <label for="kop_surat_image">Kop Surat : </label><br>
                                <img src="" style="height: 80px;" id="img_kop_surat_image">
                                <input type="hidden" id="kop_surat_image_lama" name="kop_surat_image_lama">
                                <input type="file" name="kop_surat_image" id="kop_surat_image" class="form-control" accept="image/x-png,image/jpg,image/gif,image/jpeg">                                
                            </div> 
                                  
                            <div class="form-group">
                                <label for="facebook">Facebook Sekolah : </label>
                                <input type="url" name="facebook" id="facebook" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="twitter">Twitter Sekolah : </label>
                                <input type="url" name="twitter" id="twitter" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="youtube">Youtube Sekolah : </label>
                                <input type="url" name="youtube" id="youtube" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="instagram">Instagram Sekolah : </label>
                                <input type="url" name="instagram" id="instagram" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="motto">Motto Sekolah : </label>
                                <textarea name="motto" id="motto" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4 mt-4">
                    <div class="form-group">
                        <label for="sambutan_kepala_sekolah">Sambutan Kepala Sekolah : </label>
                        <textarea name="sambutan_kepala_sekolah" id="sambutan_kepala_sekolah" class="form-control ckeditor"><?= $pengaturan['sambutan_kepala_sekolah']; ?></textarea>
                        
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" id="simpan">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <script type="text/javascript" src="<?=base_url('assets/js/pengaturan/pengaturan.js')?>"></script>

     

 