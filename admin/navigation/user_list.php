<?php
  require_once 'header_navigation.php';
  $no = 1;
  
  if (!isset($_SESSION['userId'])) {
    // exit(header("Location: ./pages/signin.php"));
    echo "<script>window.location.href = './pages/signin.php'; </script>";
    exit();
  } else { 

    // List dokter
    $query = $pdo->prepare("SELECT * FROM user WHERE user_type = 1 ORDER BY full_name ASC");
    $query->execute();
    $doctors = $query->fetchAll(PDO::FETCH_ASSOC);

    // List pasien
    $query = $pdo->prepare("SELECT * FROM user WHERE user_type = 0 ORDER BY full_name ASC");
    $query->execute();
    $patients = $query->fetchAll(PDO::FETCH_ASSOC);
  }
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">List User</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">List User</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-12">

          <div class="card">
            <div class="card-header border-0">
              <!-- Message -->
                <?php if(isset($_SESSION['error'])) { ?>
                  <div class="card-header bg-transparent px-0">
                      <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                  </div>
                <?php 
                    unset($_SESSION['error']);
                  } elseif (isset($_SESSION['success'])) { ?>
                    <div class="card-header bg-transparent px-0">
                      <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                    </div>
                <?php 
                    unset($_SESSION['success']);
                  }
                ?>
              <div class="row align-items-center">  
                <div class="col">
                  <h3 class="mb-0">List Dokter</h3>
                </div>
                <div class="col text-right">
                  <a href="../pages/signup.php" class="btn btn-sm btn-primary">Tambah</a>
                </div>
              </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <?php 
                        if(!empty($doctors)) { ?>
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                      <tr>
                                          <th scope="col">No</th>
                                          <th scope="col">Username</th>
                                          <th scope="col">Email</th>
                                          <th scope="col">Fullname</th>
                                          <th scope="col">Tanggal Lahir</th>
                                          <th scope="col">Alamat</th>
                                          <th scope="col">Kota</th>
                                          <th scope="col">Negara</th>
                                          <th scope="col">Kode POS</th>
                                          <th scope="col">Bio</th>
                                          <th scope="col">Aksi</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($doctors as $data) { ?>
                                            <tr>
                                                <th scope="row">
                                                    <?= $no++ ?>
                                                </th>
                                                <td>
                                                    <?= $data['username'] ?>
                                                </td>
                                                <th>
                                                    <?= $data['email'] ?>
                                                </th>
                                                <th>
                                                    <?= $data['full_name'] ?>
                                                </th>
                                                <th>
                                                    <?= $data['birth_date'] ?>
                                                </th>
                                                <th>
                                                    <?= $data['address'] ?>
                                                </th>
                                                <th>
                                                    <?= $data['city'] ?>
                                                </th>
                                                <th>
                                                    <?= $data['country'] ?>
                                                </th>
                                                <th>
                                                    <?= $data['postal_code'] ?>
                                                </th>
                                                <th>
                                                    <?= $data['bio'] ?>
                                                </th>
                                                <td>
                                                  <div class="dropdown">
                                                    <a href="#" 
                                                      class="btn btn-sm btn-icon-only-text-light" 
                                                      role="button"
                                                      data-toggle="dropdown"
                                                      aria-haspopup="true"
                                                      aria-expanded="false">
                                                      <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                      <a href="user_list.php?page=user-delete&id=<?= $data['id'] ?>" class="dropdown-item">Hapus</a>
                                                    </div>
                                                  </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                    <?php } else { ?>
                        <div class="card-header bg-transparent">
                            <div class="alert alert-danger">Data Kosong!</div>
                        </div>
                    <?php } ?>
                </form>
            </div>
            </div>
          </div>

          <div class="card mt-2">
            <div class="card-header border-0">
              <div class="row align-items-center">  
                <div class="col">
                  <h3 class="mb-0">List Pasien</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <?php if(!empty($patients)) { ?>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Fullname</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Kota</th>
                            <th scope="col">Negara</th>
                            <th scope="col">Kode POS</th>
                            <th scope="col">Bio</th>
                            <th scope="col">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($patients as $data) { ?>
                              <tr>
                                  <th scope="row">
                                      <?= $no++ ?>
                                  </th>
                                  <td>
                                      <?= $data['username'] ?>
                                  </td>
                                  <th>
                                      <?= $data['email'] ?>
                                  </th>
                                  <th>
                                      <?= $data['full_name'] ?>
                                  </th>
                                  <th>
                                      <?= $data['birth_date'] ?>
                                  </th>
                                  <th>
                                      <?= $data['address'] ?>
                                  </th>
                                  <th>
                                      <?= $data['city'] ?>
                                  </th>
                                  <th>
                                      <?= $data['country'] ?>
                                  </th>
                                  <th>
                                      <?= $data['postal_code'] ?>
                                  </th>
                                  <th>
                                      <?= $data['bio'] ?>
                                  </th>
                                  <td>
                                    <div class="dropdown">
                                      <a href="#" 
                                        class="btn btn-sm btn-icon-only-text-light" 
                                        role="button"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                      </a>
                                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="user_list.php?page=user-delete&id=<?= $data['id'] ?>" class="dropdown-item">Hapus</a>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                          <?php } ?>
                      </tbody>
                  </table>
                </div>
              <?php } else { ?>
                  <div class="card-header bg-transparent">
                      <div class="alert alert-danger">Data Kosong!</div>
                  </div>
              <?php } ?>
            </div>
          </div>

        </div>
      </div>

<?php require_once 'footer_dashboard.php'; ?>