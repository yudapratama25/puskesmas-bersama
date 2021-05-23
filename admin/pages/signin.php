<?php
  require_once '../../connection.php';
  require_once 'header_login.php';
  if (isset($_POST['submitLogin'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $query = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $query->execute([$username]);

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      if (password_verify($password, $user['password'])) {
?>
<script type="text/javascript">
  window.location.href = '../navigation/dashboard.php';
</script>
<?php
  $_SESSION['userId'] = $user['id'];
  // header("Location: ../navigation/dashboard.php");
} 
else {
  $_SESSION['error'] = 'Password Anda Salah';
}
} else {
  $_SESSION['error'] = 'Username Tidak Ditemukan';
}
}
?>
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="card-header bg-transparent px-0">
                  <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                  <?php 
                      unset($_SESSION['error']);
                    }  elseif (isset($_SESSION['success'])) { ?>
                      <div class="card-header bg-transparent px-0">
                        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                      </div>
                  <?php 
                      unset($_SESSION['success']);
                    }
                  ?>
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="signup.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        <form method="POST" action="" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Masukan Username" required/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Masukan Password" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Ingat saya</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submitLogin" id="submitLogin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
  <?php require_once 'footer_login.php'; ?>