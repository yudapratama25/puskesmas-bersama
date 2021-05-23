<?php
require_once 'header_navigation.php';
  $no = 1;
  
  if (!isset($_SESSION['userId'])) {
    // exit(header("Location: ./pages/signin.php"));
    echo "<script>window.location.href = './pages/signin.php'; </script>";
    exit();
  } else { 
    
    // Antrian pasien
    if ($userData['user_type'] == 1 || $userData['user_type'] == 2) {
      $query = $pdo->prepare("SELECT * FROM antrian_pasien");
      $query->execute();
      $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    } elseif($userData['user_type'] == 0) {
      $query = $pdo->prepare("SELECT *, transactions.id AS transaction_id FROM riwayat_kunjungan INNER JOIN riwayat_obat ON riwayat_kunjungan.id_visithistory = riwayat_obat.id_visithistory INNER JOIN transactions ON riwayat_kunjungan.id_visithistory = transactions.id_visithistory WHERE riwayat_kunjungan.username = ? GROUP BY visit_date ORDER BY visit_date ASC");
      $query->execute([$userData['username']]);
      $datas = $query->fetchAll(PDO::FETCH_ASSOC);
    }
  }
?>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Daftar Pasien</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="dashboard.php?page=dashboard"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="dashboard.php?page=dashboard">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Daftar Pasien</li>
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
                  <h3 class="mb-0">
                    <?php if ($userData['user_type'] == 0) {
                      echo "Riwayat Kunjungan Anda";
                     } else {
                       echo "Daftar Pasien Hari Ini";
                     } ?>
                  </h3>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush table-striped table-hover">
                <thead class="thead-light">
                  <tr>
                    <?php if ($userData['user_type'] == 0) { ?>
                      <th scope="col">No</th>
                      <th scope="col">Penyakit Diderita</th>
                      <th scope="col">Obat Digunakan</th>
                      <th scope="col">Catatan</th>
                      <th scope="col">Tanggal Kunjungan</th>
                      <th scope="col">Transaksi</th>
                    <?php } else { ?>
                      <th scope="col">No Urut</th>
                      <th scope="col">Nomor Pendaftaran</th>
                      <th scope="col">Nama Pasien</th>
                      <th scope="col">Poliklinik</th>
                      <th scope="col">Usia</th>
                      <th scope="col">Keluhan</th>
                      <th scope="col">Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  if ($userData['user_type'] == 0) {
                    if(!empty($datas)) { foreach ($datas as $data) {
                      $queryMedicine = $pdo->prepare("SELECT *, obat.id AS id_medicine FROM riwayat_obat INNER JOIN obat ON riwayat_obat.id_medicine = obat.id WHERE riwayat_obat.id_visithistory = ?");
                      $queryMedicine->execute([$data['id_visithistory']]);
                      $medicines = $queryMedicine->fetchAll(PDO::FETCH_ASSOC);
                      $medicine = [];
                      ?>
                      <tr>
                        <th scope="row">
                          <?= $no++ ?>
                        </th>
                        <th>
                          <?= $data['disease'] ?>
                        </th>
                        <td>
                          <?php foreach($medicines as $drug) { ?>
                            <?php echo $drug['name'] . ' | ' . $drug['dose'] ?> <hr class="my-1"/>
                          <?php } ?>
                        </td>
                        <td>
                          <?= $data['note'] ?>
                        </td>
                        <td>
                          <?= $data['visit_date'] ?>
                        </td>
                        <td>
                          Biaya Berobat : Rp <?= number_format($data['total'], 0, '.', ',') ?>
                          <hr class="my-1" />
                          Total Bayar : Rp <?= number_format($data['bayar'], 0, '.', ',') ?>
                          <?php if ($data['kembali'] > 0): ?>
                          <hr class="my-1" />
                          Kembali : Rp <?= number_format($data['kembali'], 0, '.', ',') ?>
                          <?php endif ?>
                        </td>
                      </tr>
                    <?php } } else { ?>
                      <tr>
                        <td></td>
                        <td><h4>Anda belum memiliki riwayat kunjungan, silahkan mendaftarkan diri anda</h4></td>
                      </tr>
                    <?php }                 
                  } elseif ($userData['user_type'] == 1) {
                    if(!empty($datas)) { foreach ($datas as $data) { ?>
                     <tr>
                       <th scope="row">
                         <?= $no++ ?>
                       </th>
                       <td>
                         <?= $data['id'] ?>
                       </td>
                       <td>
                         <?= $data['name'] ?>
                       </td>
                       <td>
                         <?= $data['poliklinik'] ?>
                       </td>
                       <td>
                         <?= $data['age'] ?>
                       </td>
                       <td>
                         <?= $data['symptom'] ?>
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
                              <a href="../pages/patient_action.php?id=<?= $data['id'] ?>" class="dropdown-item">Tindakan</a>
                              <a href="dashboard.php?page=patient-delete&id=<?= $data['id'] ?>" class="dropdown-item">Hapus</a>
                            </div>
                          </div>
                        </td>
                     </tr>
                   <?php }  }
                    else { ?>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><h4>Belum ada antrian hari ini</h4></td>
                      </tr>
                    <?php }  
                  } elseif ($userData['user_type'] == 2) {
                    if(!empty($datas)) { foreach ($datas as $data) { ?>
                     <tr>
                       <th scope="row">
                         <?= $no++ ?>
                       </th>
                       <td>
                         <?= $data['id'] ?>
                       </td>
                       <td>
                         <?= $data['name'] ?>
                       </td>
                       <td>
                         <?= $data['poliklinik'] ?>
                       </td>
                       <td>
                         <?= $data['age'] ?>
                       </td>
                       <td>
                         <?= $data['symptom'] ?>
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
                              <a href="dashboard.php?page=patient-delete&id=<?= $data['id'] ?>" class="dropdown-item">Hapus</a>
                            </div>
                          </div>
                        </td>
                     </tr>
                   <?php } }
                    else { ?>
                      <tr>
                        <td></td>
                        <td></td>
                        <td><h4>Belum ada antrian hari ini</h4></td>
                      </tr>
                    <?php }  
                  }
                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

<?php require_once 'footer_dashboard.php'; ?>