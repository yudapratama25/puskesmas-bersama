<?php
  require_once '../../connection.php';
  require_once '../backend.php';
  require_once '../../function.php';
  require_once 'header_navigation.php';
  
  if (!isset($_SESSION['userId'])) {
    // exit(header("Location: ../pages/signin.php"));
    echo "<script>window.location.href = '../pages/signin.php'; </script>";
    exit();
  } else { 
    // User yg login
    $userData = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $userData->execute([$_SESSION['userId']]);
    $userData = $userData->fetch(PDO::FETCH_ASSOC);
  }
?>
    <!-- Header -->
    <!-- Header -->
    <div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-7 col-md-10">
            <h1 class="display-2 text-white">Halo <?= $userData['full_name'] ?></h1>
            <p class="text-white mt-0 mb-5">Ini adalah halaman profil anda. Anda dapat mengedit data diri anda yang telah terdaftar disini.</p>
            
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-4 order-xl-2">
          <div class="card card-profile">
            <img src="../assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="../assets/img/theme/team-4.jpg" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              <div class="d-flex justify-content-between">
                <a href="https://www.facebook.com/<?= $userData['username'] ?>" class="btn btn-sm btn-info  mr-4 ">Connect</a>
                <a href="https://www.facebook.com/<?= $userData['username'] ?>" class="btn btn-sm btn-default float-right">Message</a>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="text-center">
                <h5 class="h3">
                  <?= $userData['full_name']; ?><span class="font-weight-light">, <?= calculate_age($userData['birth_date']) ?></span>
                </h5>
                <div class="h5 font-weight-300">
                  <i class="ni location_pin mr-2"></i><?= $userData['city'] ?>, <?= $userData['country'] ?>
                </div>
                <div class="h5 mt-4">
                  <i class="ni business_briefcase-24 mr-2"></i><?php
                    switch ($userData['user_type']) {
                      case 0:
                        echo "Pasien - Puskesmas Bersama";
                        break;

                      case 1:
                        echo "Dokter - Puskesmas Bersama";
                        break;

                      case 2:
                        echo "Administrator - Puskesmas Bersama";
                        break;
                      
                      default:
                        echo "Tidak Diketahui";
                        break;
                    }
                  ?>
                </div>
                <div>
                  <i class="ni education_hat mr-2"></i><?php if ($userData['user_type'] == 1) {
                    echo "Fakultas Kedokteran Universitas Indonesia";
                  } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit profile </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Message -->
              <div class="card-header bg-transparent">
                <?php if(isset($_SESSION['error'])) { ?>
                  <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php 
                    unset($_SESSION['error']);
                  } elseif (isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                <?php 
                    unset($_SESSION['success']);
                  }
                ?>
              </div>
              <form action="" method="POST">
                <h6 class="heading-small text-muted mb-4">Data pengguna</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Username</label>
                        <input type="text" id="input-username" name="input-username" class="form-control" placeholder="Username" value="<?=$userData['username'] ?>" readonly>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email address</label>
                        <input type="email" id="input-email" name="input-email" class="form-control" placeholder="<?=$userData['email'] ?>" readonly >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-fullname">Fullname</label>
                        <input type="text" id="input-fullname" name="input-fullname" class="form-control" placeholder="Fullname" value="<?=$userData['full_name'] ?>" required>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Informasi</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">Alamat Lengkap</label>
                        <input id="input-address" class="form-control" name="input-address" placeholder="Alamat Lengkap" value="<?= $userData['address'] ?>" required type="text">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">Kota</label>
                        <input type="text" id="input-city" class="form-control" name="input-city" placeholder="Kota" value="<?= $userData['city'] ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Negara</label>
                        <input type="text" id="input-country" class="form-control" name="input-country" placeholder="Negara" value="<?= $userData['country'] ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-postal-code">Kode POS</label>
                        <input type="number" id="input-postal-code" class="form-control" name="input-postal-code" placeholder="Kode POS" value="<?= $userData['postal_code'] ?>" required>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Description -->
                <h6 class="heading-small text-muted mb-4">Tentang Saya</h6>
                <div class="pl-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Bio Saya</label>
                    <textarea rows="4" id="input-bio" class="form-control" name="input-bio" placeholder="Berapa kata tentang dirimu ..."><?= $userData['bio'] ?></textarea>
                  </div>
                </div>
                
                <input type="hidden" name="updateProfile">
                    <button class="btn btn-sm btn-primary">
                      Save
                    </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center  text-lg-left  text-muted">
              &copy; <?= date('Y') ?> <a href="#" class="font-weight-bold ml-1" target="_blank">Puskesmas Bersama</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="../assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="../assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Argon JS -->
  <script src="../assets/js/argon.js?v=1.2.0"></script>
</body>

</html>