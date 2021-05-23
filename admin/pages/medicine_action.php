<?php
  require_once '../../connection.php';
  require_once 'header_login.php';

  if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == "edit" && isset($_GET['id'])) {
      $medicineId = $_GET['id'];
      // Get medicine
      $medicineQuery = $pdo->prepare("SELECT * FROM obat WHERE id = ?");
      $medicineQuery->execute([$medicineId]);
      $medicine = $medicineQuery->fetch(PDO::FETCH_ASSOC);

      if (isset($_POST['action'])) {
        try {
          $pdo->beginTransaction();
          
          $medicineName = filter_input(INPUT_POST, 'input-medicine-name', FILTER_SANITIZE_STRING);
          $price = filter_input(INPUT_POST, 'input-price', FILTER_SANITIZE_STRING);
  
          $query  = "UPDATE obat SET name = ?, price = ? WHERE id = ?";
          $pdo->prepare($query)->execute([$medicineName, $price, $medicineId]);
    
          $pdo->commit();

          $validation = $pdo->prepare("SELECT * FROM obat WHERE id = ? AND name = ? AND price = ?");
          $validation->execute([$medicineId, $medicineName, $price]);
    
          if ($validation->rowCount() < 0) {
            $_SESSION['error'] = "Gagal Mengubah Data!";
          } else {
            $_SESSION['success'] = "Sukses Mengubah Data!" ;
            // header("Location: ../navigation/medicine_list.php");
            echo "<script>window.location.href = '../navigation/medicine_list.php'; </script>";
          }
        } catch (Exception $e) {
          die($e->getMessage());
          $pdo->rollback();
        } 
      }

    } elseif ($page == "add") {
      if (isset($_POST['action'])) {
        try {
          $pdo->beginTransaction();
          
          $medicineName = filter_input(INPUT_POST, 'input-medicine-name', FILTER_SANITIZE_STRING);
          $price = filter_input(INPUT_POST, 'input-price', FILTER_SANITIZE_STRING);
  
          $query  = "INSERT INTO obat (name, price) VALUES (?, ?)";
          $pdo->prepare($query)->execute([$medicineName, $price]);
    
          $pdo->commit();

          $validation = $pdo->prepare("SELECT * FROM obat WHERE name = ? AND price = ?");
          $validation->execute([$medicineName, $price]);
    
          if ($validation->rowCount() < 0) {
            $_SESSION['error'] = "Gagal Menambah Data!";
          } else {
            $_SESSION['success'] = "Sukses Menambah Data!" ;
            // header("Location: ../navigation/medicine_list.php");
            echo "<script>window.location.href = '../navigation/medicine_list.php'; </script>";
          }
        } catch (Exception $e) {
          die($e->getMessage());
          $pdo->rollback();
        } 
      }
    }

  } else {
    $_SESSION['error'] = "Masukan ID!";  
    // header("Location: ../navigation/medicine_list.php");
    echo "<script>window.location.href = '../navigation/medicine_list.php'; </script>";    
  }
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
                <h2 class="form-title"><?php if($page == "edit") echo "Ubah Data Obat"; elseif($page == "add") echo "Tambah Data Obat"; ?></h2>
                
                <form action="" method="POST">
                  <h6 class="heading-small text-muted mb-4">Nama Obat</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="text" id="input-medicine-name" value="<?php if($page == "edit") echo $medicine['name'] ?>" name="input-medicine-name" class="form-control" placeholder="Masukan Nama Obat .." required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="my-4" />
                  <!-- Description -->
                  <h6 class="heading-small text-muted mb-4">Harga Obat</h6>
                  <div class="pl-lg-4">
                    <div class="form-group">
                    <input type="number" id="input-price" name="input-price" value="<?php if($page == "edit") echo $medicine['price'] ?>" class="form-control" placeholder="Masukan Jumlah Harga .." required>
                    </div>
                  </div>
                  
                  <hr class="my-4" />
                  <input type="hidden" name="action">
                      <button class="btn btn-sm btn-primary">
                        Save
                      </button>
                </form>
                <div class="signin-image">
                </div>
            </div>
        </section>
        
        
  <?php require_once 'footer_login.php'; ?>