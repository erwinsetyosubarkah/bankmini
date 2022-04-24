    <!-- Sidebar -->

    <?php if($_SESSION['user']['level'] == 'Teller' || $_SESSION['user']['level'] == 'Operator' || $_SESSION['user']['level'] == 'Administrator'): ?>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>beranda-admin">
        <div class="sidebar-brand-icon">
          <img src="<?= base_url("assets/"); ?>img/icon/<?= $pengaturan['logo']; ?>" alt="" class="logo-sidebar">
        </div>
        <?php $level = strtolower($_SESSION['user']['level']); ?>
        <div class="sidebar-brand-text mx-3"><?= $level; ?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dasbor -->
      <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>beranda-admin">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dasbor</span></a>
      </li>

            
      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book"></i>
          <span>Tabungan Nasabah</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">  
              <a class="collapse-item" href="<?= base_url(); ?>setoran-masuk"><i class="fas fa-fw fa-shopping-cart"></i> Setoran Masuk</a>
              <a class="collapse-item" href="<?= base_url(); ?>penarikan-tabungan"><i class="fas fa-fw fa-cart-arrow-down"></i> Penarikan Tabungan</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->      
        <li class="nav-item active">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataPengguna" aria-expanded="true" aria-controls="collapseDataPengguna">
            <i class="fas fa-fw fa-money-check-alt"></i>
            <span>Transaksi Pembayaran</span>
          </a>
          <div id="collapseDataPengguna" class="collapse" aria-labelledby="headingDataPengguna" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="<?= base_url(); ?>pembayaran-siswa"><i class="fas fa-fw fa-dollar-sign"></i>
              Pembayaran Siswa</a>
              <a class="collapse-item" href="<?= base_url(); ?>penarikan-saldo"><i class="fas fa-fw fa-university"></i> Penarikan Saldo Bank</a>
            </div>
          </div>
        </li>
      
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item active">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true" aria-controls="collapseMaster">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Nasabah</span>
          </a>
          <div id="collapseMaster" class="collapse" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded"> 
            <?php if( $_SESSION['user']['level'] == 'Operator' || $_SESSION['user']['level'] == 'Administrator'): ?>        
              <a class="collapse-item" href="<?= base_url(); ?>nasabah"><i class="fas fa-fw fa-users"></i> Data Nasabah</a>
            <?php endif; ?>
              <a class="collapse-item" href="<?= base_url(); ?>cek-saldo-nasabah"><i class="fas fa-fw fa-dollar-sign"></i> Cek Saldo Nasabah</a>
            <?php if( $_SESSION['user']['level'] == 'Operator' || $_SESSION['user']['level'] == 'Administrator'): ?> 
              <a class="collapse-item" href="<?= base_url(); ?>nasabah-tidak-aktif"><i class="fas fa-fw fa-exclamation"></i> Nasabah Tidak Aktif</a> 
            <?php endif; ?>                
              
            </div>
          </div>
        </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAkademik" aria-expanded="true" aria-controls="collapseAkademik">
          <i class="fas fa-fw fa-list-alt"></i>
          <span>Transaksi Semua</span>
        </a>
        <div id="collapseAkademik" class="collapse" aria-labelledby="headingAkademik" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
          <?php if( $_SESSION['user']['level'] == 'Operator' || $_SESSION['user']['level'] == 'Administrator'): ?> 
            <a class="collapse-item" href="<?= base_url(); ?>rekap-tabungan"><i class="fas fa-fw fa-folder-open"></i> Rekap Tabungan</a>
          <?php endif; ?>
            <a class="collapse-item" href="<?= base_url(); ?>cek-saldo-tabungan"><i class="fas fa-fw fa-dollar-sign"></i> Cek Saldo Tabungan</a>
          <?php if( $_SESSION['user']['level'] == 'Operator' || $_SESSION['user']['level'] == 'Administrator'): ?> 
            <a class="collapse-item" href="<?= base_url(); ?>rekap-pembayaran"><i class="fas fa-fw fa-folder-open"></i> Rekap Pembayaran</a>          
          <?php endif; ?>
            <a class="collapse-item" href="<?= base_url(); ?>cek-saldo-bankmini"><i class="fas fa-fw fa-dollar-sign"></i> Cek Saldo Bankmini</a>            

          </div>
        </div>
      </li>
      
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item active">
      <?php if($_SESSION['user']['level'] == 'Administrator'): ?> 
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAbsensi" aria-expanded="true" aria-controls="collapseAbsensi">
          <i class="fas fa-fw fa-cogs"></i>
          <span>Pengaturan</span>
        </a>
        <div id="collapseAbsensi" class="collapse" aria-labelledby="headingAbsensi" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">            
            <a class="collapse-item" href="<?= base_url(); ?>pengaturan-admin"><i class="fas fa-fw fa-cog"></i> Pengaturan Admin</a>
            <a class="collapse-item" href="<?= base_url(); ?>data-pengguna"><i class="fas fa-fw fa-cog"></i> Data Pengguna</a>
            <a class="collapse-item" href="<?= base_url(); ?>pengaturan-jurusan"><i class="fas fa-fw fa-cog"></i> Jurusan</a>
            <a class="collapse-item" href="<?= base_url(); ?>pengaturan-kelas"><i class="fas fa-fw fa-cog"></i> Kelas</a>
            <a class="collapse-item" href="<?= base_url(); ?>pengaturan-tanda_pengenal"><i class="fas fa-fw fa-cog"></i> Tanda Pengenal</a>
            <a class="collapse-item" href="<?= base_url(); ?>pengaturan-jenis_setoran"><i class="fas fa-fw fa-cog"></i> Jenis Setoran</a>
            <a class="collapse-item" href="<?= base_url(); ?>pengaturan-naik_kelas"><i class="fas fa-fw fa-cog"></i> Naik Kelas</a>
          </div>
        </div>
      <?php endif; ?>
    </li>
          
      <!-- Nav Item - Tables -->
      <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>profil"><i class="fas fa-fw fa-user-secret"></i> <span>Profil</span></a>
      </li>
      
      
      <!-- Nav Item - Tables -->
      <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Keluar</span></a>
      </li>
      

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <?php endif; ?>

    
