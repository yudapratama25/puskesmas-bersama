<?php
  require_once '../../connection.php';
  require_once '../../function.php';
  require_once '../backend.php';
  require_once 'header_login.php';

  if (isset($_POST['daftar'])) {
    $pdo->beginTransaction();
    try {
      $username = $userData['username'];
      $fullname = $userData['full_name'];
      $usia = calculate_age($userData['birth_date']);
      $keluhan = filter_input(INPUT_POST, 'keluhan', FILTER_SANITIZE_STRING);
      $poliklinik = filter_input(INPUT_POST, 'poliklinik', FILTER_SANITIZE_STRING);
      $data = [$username, $fullname, $poliklinik, $usia, $keluhan];

      $query = "INSERT INTO antrian_pasien (username, name, poliklinik, age, symptom, date) VALUES (?, ?, ?, ?, ?, now())";
    
      $pdo->prepare($query)->execute($data);

      $pdo->commit();

      $validation = $pdo->prepare("SELECT * FROM antrian_pasien WHERE name = ? AND poliklinik = ? AND age = ? LIMIT 1");
      $validation->execute([$fullname, $poliklinik, $usia]);

      if ($validation->rowCount() < 0) {
        $_SESSION['error'] = "Gagal Mendaftarkan Data!";
      } else {
        $data = $validation->fetchAll(PDO::FETCH_ASSOC);    
        $_SESSION['success'] = "Terima Kasih telah mendaftar! Data anda telah berhasil masuk ke sistem\nDengan nomor pendaftaran: <b>". $data[0]['id'] . "</b>";
        // header("Location: ../navigation/dashboard.php");
        echo "<script>window.location.href = '../navigation/dashboard.php'; </script>";
      }
    } catch (Exception $e) {
      die($e->getMessage());
      $pdo->rollback();
    } 
  } elseif (isset($_POST['back'])) {
    // header("Location: ../navigation/dashboard.php");
    echo "<script>window.location.href = '../navigation/dashboard.php'; </script>";
  } 
?>
        <!-- Register form -->
        <section class="signup">
            <div class="container">
                <div class="card-header bg-transparent">
                  <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                  <?php 
                      unset($_SESSION['error']);
                    } 
                  ?>
                <h2 class="form-title">Pendaftaran Pasien</h2>
                <form method="POST" class="register-form" id="register-form">
                    <hr class="my-4" />
                    <!-- Description -->
                    <h6 class="heading-small text-muted mb-4">Keluhan Anda</h6>
                    <div class="form-group">
                        <textarea rows="4" id="keluhan" class="form-control" name="keluhan" placeholder="Ketikan Keluhan Anda ..." required></textarea>
                    </div>
                    <hr class="my-4" />
                    <h6 class="heading-small text-muted mb-4">Pilih Poliklinik</h6>
                    <div class="form-group">
                        <div class="input-select">
                            <select required name="poliklinik" style="width: 100%; padding: 4px" class="form-select" aria-label="Pilih Poliklinik">
                                    <option selected value="Umum">Umum</option>
                                    <option value="Gigi">Gigi</option>
                                    <option value="KIA">KIA</option>
                                    <option value="Gizi">Gizi</option>
                                    <option value="Sanitasi">Sanitasi</option>
                                    <option value="Batra">Batra</option>
                                    <option value="Psikologi">Psikologi</option>
                                    <option value="Lansia">Lansia</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="daftar" id="daftar" class="form-submit"/>    
                        <input type="submit" name="back" value="Kembali" formnovalidate class="form-submit"/>    
                    </div>
                </form>
                <hr class="my-4" />
            </div>
        </section>
        
        
  <?php require_once 'footer_login.php'; ?>