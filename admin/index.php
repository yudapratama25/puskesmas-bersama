<?php
  date_default_timezone_set("Asia/Kuala_Lumpur");

  require_once '../function.php';
  require_once 'backend.php';  
  require_once '../connection.php';

  if (isset($_GET['page'])) {
      $page = $_GET['page'];

      switch ($page) {
          case 'sign-up':
            require_once 'pages/signup.php';
            break;
          
          case 'sign-in':
            require_once 'pages/signin.php';
            break;

          case 'dashboard':
            require_once 'navigation/dashboard.php';
          break;

          default: 
            // require_once 'layout/header.php';
            require_once 'navigation/dashboard.php';
            // require_once 'layout/footer.php'; 
          break;
      }
  } else {
      require_once 'pages/signup.php';
  }
?>

