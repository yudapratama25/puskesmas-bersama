<?php
  require_once '../../connection.php';
  require_once 'header_login.php';

  if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $visitHistory = $pdo->prepare("SELECT * FROM antrian_pasien WHERE id = ?");
    $visitHistory->execute([$userId]);
    $visitData = $visitHistory->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['action'])) {
      try {
        $pdo->beginTransaction();
        $medicineData = count($_POST["input-medicine"]);
        
        $visitId = $visitData[0]['id'];
        $username = $visitData[0]['username'];
        $visitDate = $visitData[0]['date'];
        $disease = filter_input(INPUT_POST, 'input-disease', FILTER_SANITIZE_STRING);
        $note = filter_input(INPUT_POST, 'input-note', FILTER_SANITIZE_STRING);

        $query  = "INSERT INTO riwayat_kunjungan (id_visithistory, username, visit_date, disease, note) VALUES (?, ?, ?, ?, ?)";

        $pdo->prepare($query)->execute([$visitId, $username, $visitDate, $disease, $note]);
  
        $pdo->commit();
	
        if ($medicineData > 0) {
          for ($i=0; $i < $medicineData; $i++) { 
            if (trim($_POST['input-medicine'] != '') && trim($_POST['input-dose'] != '') && trim($_POST['input-qty'] != '')) {
              $pdo->beginTransaction();
              // Initialize Data
              $medicine = $_POST["input-medicine"][$i];
              $dose  = $_POST["input-dose"][$i];
              $qty  = $_POST["input-qty"][$i];
              $priceQuery = $pdo->prepare("SELECT price FROM obat WHERE id = ?");
              $priceQuery->execute([$medicine]);
              $priceData = $priceQuery->fetchAll(PDO::FETCH_ASSOC);
              $price = $priceData[0]['price'];

              $query  = "INSERT INTO riwayat_obat (id_medicine, id_visithistory, dose, qty, price) VALUES (?, ?, ?, ?, ?)";
              $pdo->prepare($query)->execute([$medicine, $visitId, $dose, $qty, $price]);
        
              $pdo->commit();
            }
          }
          $pdo->beginTransaction();
  
          $query  = "DELETE FROM antrian_pasien WHERE id =  ?";
          $pdo->prepare($query)->execute([$visitId]);
    
          $pdo->commit();

          $_SESSION['success'] = "Berhasil Memberi Tindakan!";  
          // header("Location: ../navigation/dashboard.php");
          echo "<script>window.location.href = '../navigation/dashboard.php'; </script>";
        } else {
          $_SESSION['error'] = "Masukan Obat!";
        }
      } catch (Exception $e) {
        die($e->getMessage());
        $pdo->rollback();
      } 
    }

  } else {
    $_SESSION['error'] = "Masukan ID!";  
    // header("Location: ../navigation/dashboard.php");
    echo "<script>window.location.href = '../navigation/dashboard.php'; </script>";
  }
  // Get medicine
  $medicineQuery = $pdo->prepare("SELECT * FROM obat");
  $medicineQuery->execute();
  $medicines = $medicineQuery->fetchAll(PDO::FETCH_ASSOC);
?>
        <!-- Patien Action up form -->
        <section class="signup">
            <div class="container">
                <div class="card-header bg-transparent">
                  <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                  <?php 
                      unset($_SESSION['error']);
                    } 
                  ?>
                <h2 class="form-title">Tindakan Pasien</h2>
                
                <form action="" method="POST">
                  <h6 class="heading-small text-muted mb-4">Nama Penyakit</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="text" id="input-disease" name="input-disease" class="form-control" placeholder="Masukan Nama Penyakit .." required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="my-4" />
                  <!-- Description -->
                  <h6 class="heading-small text-muted mb-4">Catatan Untuk Pasien</h6>
                  <div class="pl-lg-4">
                    <div class="form-group">
                      <textarea rows="4" id="input-note" class="form-control" name="input-note" placeholder="Berapa kata pesan untuk pasien ..."></textarea>
                    </div>
                  </div>
                  <hr class="my-4" />
                  <h6 class="heading-small text-muted mb-4">Pilih Obat</h6>
                  <div class="pl-lg-4">
                    <table id="dynamic_field">
                    <tr>
                      <td><select required name="input-medicine[]" class="form-control" aria-label="Pilih Obat">
                                    <?php foreach ($medicines as $medicine) { ?>
                                      <option value="<?= $medicine['id'] ?>"><?= $medicine['name'] ?></option>
                                    <?php } ?>
                            </select></td>
                      <td><input type="text" name="input-dose[]" placeholder="Masukan Dosis" class="form-control"/></td>
                      <td><input type="number" name="input-qty[]" placeholder="Qty" class="form-control"/></td>
                      <td><button type="button" name="add" id="add" class="btn btn-primary">Tambahkan</button></td>  
                    </tr>
                    </table>
                  </div>
                  
                  <hr class="my-4" />
                  <input type="hidden" name="action">
                      <button class="btn btn-sm btn-primary">
                        Save
                      </button>
                </form>
                <div class="signin-image">
                </div>
                    <a href="signin.php" class="signup-image-link">Sudah Memiliki Akun? Login Disini</a>
            </div>
        </section>
        
        
  <?php require_once 'footer_login.php'; ?>

  <script type="text/javascript">
    $(document).ready(function(){

      var i = 1;

      $("#add").click(function(){
        i++;
        $('#dynamic_field').append('<tr id="row'+i+'"><td><select required name="input-medicine[]" class="form-control" aria-label="Pilih Obat"><?php foreach ($medicines as $medicine) { ?><option value="<?= $medicine['id'] ?>"><?= $medicine['name'] ?></option><?php } ?></select></td><td><input type="text" name="input-dose[]" placeholder="Masukan Dosis" class="form-control"/></td><td><input type="number" name="input-qty[]" placeholder="Qty" class="form-control"/></td> <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });

      $(document).on('click', '.btn_remove', function(){  
        var button_id = $(this).attr("id");   
        $('#row'+button_id+'').remove();  
      });
    });
</script>