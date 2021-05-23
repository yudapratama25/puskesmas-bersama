<?php
  if (!isset($_SESSION['userId'])) {
    // header("Location: ./pages/signin.php");
    echo "<script>window.location.href = './pages/signin.php'; </script>";
  } else { 
    $userData = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $userData->execute([$_SESSION['userId']]);
    $userData = $userData->fetch(PDO::FETCH_ASSOC);
  }

  if (isset($_GET['page']) && isset($_GET['id'])) {
    // Dashboard.php
    if ($_GET['page'] == "patient-delete") {
      $idUser = $_GET['id'];
      $query = $pdo->prepare("DELETE FROM antrian_pasien WHERE id = ?");
      $query->execute([$idUser]);

      $validation = $pdo->prepare("SELECT * FROM antrian_pasien WHERE id = ?");
      $validation->execute([$idUser]);

      if ($validation->rowCount() < 0) {
        $_SESSION['error'] = "Gagal Menghapus Data!";
      } else {
        $_SESSION['success'] = "Sukses Menghapus Data!" ;
      }
    // medicine_list.php
    } elseif ($_GET['page'] == "medicine-delete") {
        $idUser = $_GET['id'];
        $query = $pdo->prepare("DELETE FROM obat WHERE id = ?");
        $query->execute([$idUser]);

        $validation = $pdo->prepare("SELECT * FROM obat WHERE id = ?");
        $validation->execute([$idUser]);

        if ($validation->rowCount() < 0) {
          $_SESSION['error'] = "Gagal Menghapus Data!";
        } else {
          $_SESSION['success'] = "Sukses Menghapus Data!" ;
        }
    // user_list.php
    } elseif ($_GET['page'] == "user-delete") {
        $idUser = $_GET['id'];
        $query = $pdo->prepare("DELETE FROM user WHERE id = ?");
        $query->execute([$idUser]);

        $validation = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $validation->execute([$idUser]);

        if ($validation->rowCount() < 0) {
          $_SESSION['error'] = "Gagal Menghapus Data!";
        } else {
          $_SESSION['success'] = "Sukses Menghapus Data!" ;
        }
    }
  }

  if (isset($_POST['logout'])) {
    unset($_SESSION['userId']);
    session_unset();
    session_destroy();
    // header("Location: ./pages/login/login.php");
    echo "<script>window.location.href = window.location.origin + '/admin/pages/signin.php'; </script>";
  } elseif(isset($_POST['updateProfile'])) {
    $pdo->beginTransaction();
    try {
      $id = $_SESSION['userId'];
      $fullname = filter_input(INPUT_POST, 'input-fullname', FILTER_SANITIZE_STRING);
      $address = filter_input(INPUT_POST, 'input-address', FILTER_SANITIZE_STRING);
      $city = filter_input(INPUT_POST, 'input-city', FILTER_SANITIZE_STRING);
      $country = filter_input(INPUT_POST, 'input-country', FILTER_SANITIZE_STRING);
      $postalCode = filter_input(INPUT_POST, 'input-postal-code', FILTER_SANITIZE_STRING);
      $bio = filter_input(INPUT_POST, 'input-bio', FILTER_SANITIZE_STRING);
      $data = [$fullname, $address, $city, $country, $postalCode, $bio, $id];

      $query = "UPDATE user SET full_name = ?, address = ?, city = ?, country = ?, postal_code = ?, bio = ? WHERE id = ?";
      $pdo->prepare($query)->execute($data);

      $pdo->commit();

      $validation = $pdo->prepare("SELECT * FROM user WHERE id = ? AND full_name = ? AND address = ? AND city = ? AND country = ? AND postal_code = ? AND bio = ?");
      $validation->execute([$id, $fullname, $address, $city, $country, $postalCode, $bio]);

      if ($validation->rowCount() < 0) {
        $_SESSION['error'] = "Gagal Mengubah Data!";
      } else {
        $_SESSION['success'] = "Sukses Mengubah Data!" ;
      }
    } catch (Exception $e) {
      $pdo->rollback();
      die($e->getMessage());
    } 
  }