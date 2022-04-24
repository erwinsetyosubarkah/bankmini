    </div>
    <!-- End of Main Content -->

    
    <!-- Footer -->
    <footer class="sticky-footer bg-white">
            <div class="container my-auto">
              <div class="copyright text-center my-auto">
                <span>Copyright &copy; 2021 </span><span style="color: red;">&hearts;</span><span> Erwin Setyo Subarkah</span>
              </div>
            </div>
          </footer>
          <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin akan keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih tombol "Keluar" dibawah ini jika kamu yakin akan mengakhiri sesi kamu saat ini.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="<?= base_url(); ?>logout-user">Keluar</a>
        </div>
      </div>
    </div>
  </div>

  <?php include "modal_ubah_password.php"; ?>

  <script type="text/javascript" src="<?=base_url('assets/js/ubah_password/ubah_password.js')?>"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url("assets/"); ?>sbadmin/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url("assets/"); ?>sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url("assets/"); ?>sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url("assets/"); ?>sbadmin/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url("assets/"); ?>sbadmin/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url("assets/"); ?>sbadmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Integrasi ckeditor5 -->
  <script src="<?= base_url("assets/"); ?>ckeditor/ckeditor.js"></script>

  
  <!-- Select2 -->
  <script src="<?= base_url("assets/"); ?>select2/js/select2.min.js"></script>



  

</body>

</html>
