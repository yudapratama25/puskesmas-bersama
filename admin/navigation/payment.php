<?php
  require_once 'header_navigation.php';
  $no = 1;
  
  if (!isset($_SESSION['userId'])) {
    // exit(header("Location: ./pages/signin.php"));
    echo "<script>window.location.href = './pages/signin.php'; </script>";
    exit();
  } else { 
    if ($userData['user_type'] == 2) {

        // List transaction
        $query = $pdo->prepare("SELECT *, riwayat_kunjungan.id AS id_riwayat_kunjungan, user.id AS user_id FROM riwayat_kunjungan INNER JOIN user ON riwayat_kunjungan.username = user.username GROUP BY riwayat_kunjungan.id_visithistory ORDER BY riwayat_kunjungan.visit_date DESC");
        $query->execute();
        $patients = $query->fetchAll(PDO::FETCH_ASSOC);

        $idPayment = "";
        $pay = false;
        if (isset($_POST['input-payment-id'])) {
            $totalPrice = 0;
            $money = "";
            $query = $pdo->prepare("SELECT * FROM riwayat_obat WHERE id_visithistory = ?");
            $idPayment = $_POST['input-payment-id'];
            $query->execute([$idPayment]);
            $datas = $query->fetchAll(PDO::FETCH_ASSOC);
            $firstLoad = false;
            if (isset($_POST['input-money'])) {
                $money = $_POST['input-money'];
                $pay = true;
            }
        } else {
            $firstLoad = true;
        }
    } else {
        // exit(header("Location: dashboard.php"));
        echo "<script>window.location.href = 'dashboard.php'; </script>";
        exit();
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
              <h6 class="h2 text-white d-inline-block mb-0">Pembayaran</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
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
                  <h3 class="mb-0">Pembayaran</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <!-- Description -->
                    <h6 class="heading-small text-muted mb-4">No Pendaftaran</h6>
                    <div class="form-group">
                        <select required name="input-payment-id" class="form-select form-control">
                            <?php foreach ($patients as $patient): ?>
                                <option value="<?= $patient['id_visithistory'] ?>" <?= ($idPayment != "" && $idPayment == $patient['id_visithistory']) ? 'selected' : null ?>>
                                    #<?= $patient['id_visithistory'] ?> - <?= $patient['full_name'] ?> (<?= $patient['disease'] ?>)
                                </option>
                            <?php endforeach ?>
                        </select>
                        <input type="submit" name="check-id" value="Check" class="btn btn-primary mt-3">
                    </div>
                    <?php 
                        if(!empty($datas)) { ?>
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Obat</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Harga</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datas as $data) { 
                                            $queryMedicine = $pdo->prepare("SELECT name FROM obat WHERE id = ?");
                                            $queryMedicine->execute([$data['id_medicine']]);
                                            $medicineName = $queryMedicine->fetch(PDO::FETCH_ASSOC);  ?>
                                            <tr>
                                                <th scope="row">
                                                    <?= $no++ ?>
                                                </th>
                                                <td>
                                                    <?= implode(", ", $medicineName) ?>
                                                </td>
                                                <th>
                                                    <?= $data['qty'] ?>
                                                </th>
                                                <td>
                                                    <?php
                                                        $totalPrice += $data['price'];
                                                        echo $data['price']; ?>
                                                </td>  
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <h6 class="heading-small text-muted mb-4">Total</h6>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Rp.0" value="Rp. <?= $totalPrice ?>" readonly>
                                </div>
                                <h6 class="heading-small text-muted mb-4">Uang</h6>
                                <div class="form-group">
                                    <input type="text" id="input-money" name="input-money" class="form-control" value="<?=$money ?>" placeholder="Masukan Jumlah Uang" required>
                                </div>
                                <div class="form-group form-button">
                                    <input type="submit" name="input-pay" value="Bayar" id="input-pay" value="Bayar" class="btn btn-primary"/>        
                                </div>
                                <?php if ($pay) { if ($money >= $totalPrice) { ?>
                                    <h6 class="heading-small text-muted mb-4">Kembalian</h6>
                                    <div class="form-group">
                                        <input type="text" id="change" name="change" class="form-control" value="Rp. <?=  $money - $totalPrice ?>" placeholder="Kembalian" readonly>
                                    </div>
                                <?php } else { ?>
                                    <div class="card-header bg-transparent">
                                        <div class="alert alert-danger">Nominal Uang Kurang!</div>
                                    </div>
                                <?php }}?>
                <?php   } elseif(!$firstLoad) { ?>
                        <div class="card-header bg-transparent">
                            <div class="alert alert-danger">Nomor pendaftaran salah</div>
                        </div>
                    <?php } ?>
                </form>
            </div>
            </div>
          </div>
        </div>

<?php require_once 'footer_dashboard.php'; ?>