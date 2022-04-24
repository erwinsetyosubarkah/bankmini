        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <div class="header">                  
              <h4 class="m-0 font-weight-bold"><i class="fas fa-fw fa-<?php echo $icon_header_halaman; ?>"></i> <?php echo $header_halaman; ?></h4>
              <span class="font-italic">Tampilan <?php echo $header_halaman; ?></span>                  
          </div>
          

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

           


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php $level = strtolower($_SESSION['user']['level']); ?>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['user']['nama_pengguna'] ?></span>    
                <?php if($_SESSION['user']['foto_pengguna'] == "" ): ?>            
                  <img class="img-profile rounded-circle" src="<?= base_url(); ?>assets/img/foto/noimage.png">
                <?php else :?>
                    <?php if(file_exists('./assets/img/foto/'.$_SESSION['user']['foto_pengguna'])): ?>
                       <img class="img-profile rounded-circle" src="<?= base_url(); ?>assets/img/foto/<?= $_SESSION['user']['foto_pengguna']; ?>">
                    <?php else: ?>
                       <img class="img-profile rounded-circle" src="<?= base_url(); ?>assets/img/foto/noimage.png">
                    <?php endif; ?>
                <?php endif; ?>
              </a>
              
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalUbahPassword">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Ubah Password
                </a>               
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url(); ?>profil">
                  <i class="fas fa-user-secret fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>               
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Keluar
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->