<?php
  require_once 'header_navigation.php';
  $no = 1;
  
  if (!isset($_SESSION['userId'])) {
    // exit(header("Location: ./pages/signin.php"));
    echo "<script>window.location.href = './pages/signin.php'; </script>";
    exit();
  } else { 
    // List Obat
    $query = $pdo->prepare("SELECT * FROM obat ORDER BY name ASC");
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
  }

  if (isset($_GET['submit_search'])) {
    $search = $_GET['search'];
    $query = $pdo->prepare("SELECT * FROM obat WHERE name LIKE '%$search%' ORDER BY name ASC");
    $query->execute();
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);
  }
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">List Obat</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">List Obat</li>
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
        <div class="col-xl-12 ">
          <div class="card">
            <div class="card-header border-0">
              <!-- Message -->
                <?php if(isset($_SESSION['error'])) { ?>
                  <div class="card-header bg-transparent">
                      <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                  </div>
                <?php 
                    unset($_SESSION['error']);
                  } elseif (isset($_SESSION['success'])) { ?>
                    <div class="card-header bg-transparent">
                      <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                    </div>
                <?php 
                    unset($_SESSION['success']);
                  }
                ?>
              <div class="row align-items-center">  
                <div class="col">
                  <h3 class="mb-0">
                    List Obat &nbsp; <a href="../pages/medicine_action.php?page=add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                  </h3>
                </div>
                <div class="col text-right">
                  <form action="" method="GET">
                    <div class="form-group d-flex">
                      <input type="text" name="search" class="form-control w-50 ml-auto mr-2" placeholder="Cari obat ...">
                      <button class="btn btn-primary" type="submit" name="submit_search">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <?php 
                        if(!empty($datas)) { ?>
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Id</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datas as $data) {?>
                                            <tr>
                                                <th scope="row">
                                                    <?= $no++ ?>
                                                </th>
                                                <td>
                                                    <?= $data['id'] ?>
                                                </td>
                                                <th>
                                                    <?= $data['name'] ?>
                                                </th>
                                                <td>
                                                    Rp. <?= $data['price'] ?>
                                                </td>  
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
                                                      <a href="../pages/medicine_action.php?page=edit&id=<?= $data['id'] ?>" class="dropdown-item">Ubah</a>
                                                      <a href="medicine_list.php?page=medicine-delete&id=<?= $data['id'] ?>" class="dropdown-item">Hapus</a>
                                                    </div>
                                                  </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                <?php   } else { ?>
                        <div class="card-header bg-transparent">
                            <div class="alert alert-danger">Data Kosong!</div>
                        </div>
                    <?php } ?>
                </form>
            </div>
            </div>
          </div>
        </div>

<?php require_once 'footer_dashboard.php'; ?>