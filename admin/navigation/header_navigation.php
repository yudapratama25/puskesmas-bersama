<?php 
  require_once 'nav_header_dashboard.php';
?>
<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="../assets/img/theme/team-4.jpg">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?= $userData['full_name'] ?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome <?= $userData['full_name'] ?>!</h6>
                </div>
                <a href="dashboard.php" class="dropdown-item">
                  <i class="ni ni-tv-2 text-primary"></i>
                  <span>Dashboard</span>
                </a>
                <a href="profile.php" class="dropdown-item">
                  <i class="ni ni-single-02 text-yellow"></i>
                  <span>Profil Saya</span>
                </a>
                <?php if ($userData['user_type'] == 0) { ?>
                    <a href="../pages/register_patient.php" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>Registrasi Pasien</span>
                    </a>
                <?php } ?>
                <?php if ($userData['user_type'] == 2) { ?>
                        <a href="../pages/signup.php" class="dropdown-item">
                            <i class="ni ni-calendar-grid-58"></i>
                            <span>Buat Akun Dokter</span>
                        </a>
                        <a href="payment.php" class="dropdown-item">
                            <i class="bi bi-currency-dollar"></i>
                            <span>Payment</span>
                        </a>
                        <a href="medicine_list.php" class="dropdown-item">
                            <i class="bi bi-file-earmark-medical-fill"></i>
                            <span>List Obat</span>
                        </a>
                        <a href="user_list.php" class="dropdown-item">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>List User</span>
                        </a>
                <?php } ?>
                <div class="dropdown-divider"></div>
                <form action="" method="POST">
                  <input type="hidden" name="logout">
                  <button class="dropdown-item">
                    <i class="ni ni-user-run"></i>
                    <span>Logout</span>    
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>