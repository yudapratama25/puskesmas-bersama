<?php
  require_once '../../connection.php';
  require_once '../backend.php';
  require_once '../../function.php';
  
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
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Puskesmas Bersama">
  <title>Puskesmas Bersama</title>
  <!-- Favicon -->
  <link rel="icon" href="../../assets/img/logo_puskermas.jpg" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="../assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="../assets/css/argon.css?v=1.2.0" type="text/css">
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <h2>Puskesmas Bersama</h1>
          <img src="../../assets/img/logo_puskermas.jpg" class="navbar-brand-img" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link " href="dashboard.php">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="profile.php">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">Profil</span>
              </a>
            </li>
            <?php if ($userData['user_type'] == 0) { ?>
              <li class="nav-item">
                <a class="nav-link" href="../pages/register_patient.php">
                  <i class="ni ni-circle-08 text-pink"></i>
                  <span class="nav-link-text">Registrasi Pasien</span>
                </a>
              </li>
            <?php } ?>
            <?php if ($userData['user_type'] == 2) { ?>
              <li class="nav-item">
                <a class="nav-link" href="../pages/signup.php">
                  <i class="ni ni-circle-08 text-pink"></i>
                  <span class="nav-link-text">Buat Akun Dokter</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="payment.php">
                  <i class="bi bi-currency-dollar"></i>
                  <span class="nav-link-text">Payment</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="medicine_list.php">
                  <i class="bi bi-file-earmark-medical-fill"></i>
                  <span class="nav-link-text">List Obat</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="user_list.php">
                  <i class="bi bi-person-lines-fill"></i>
                  <span class="nav-link-text">List User</span>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  
    