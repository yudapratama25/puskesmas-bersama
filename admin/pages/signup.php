<?php
  require_once '../../connection.php';
  require_once 'header_login.php';

    if (isset($_POST['signup'])) {
        $pdo->beginTransaction();
        try {
        $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'birth-date', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
        $postal_code = filter_input(INPUT_POST, 'postal-code', FILTER_SANITIZE_STRING);
        $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'user-type', FILTER_SANITIZE_STRING);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data = [$username, $email, $password, $fullname, $type, $date, $address, $city, $country, $postal_code, $bio];

        $validation = $pdo->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
        $validation->execute([$username, $email]);

        if ($validation->rowCount() > 0) {
            $_SESSION['error'] = "Email atau Username sudah dipakai, silahkan pakai yang lain";
        }

        $query = "INSERT INTO user (username, email, password, full_name, user_type, birth_date, address, city, country, postal_code, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $pdo->prepare($query)->execute($data);

        $pdo->commit();
        $_SESSION['success'] = "Sukses Mendaftarkan Akun!";
        if ($type == 1) {
            // exit(header("Location: ../navigation/dashboard.php"));
            echo "<script>window.location.href = '../navigation/dashboard.php'; </script>";
            exit();
        } else {
            // exit(header("Location: ../index.php?page=sign-in"));
            echo "<script>window.location.href = 'signin.php'; </script>";
            exit();
        }

        } catch (Exception $e) {
        $pdo->rollback();
        die($e->getMessage());
        } 
    } 

    if (isset($_SESSION['userId'])) {
        $userData = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $userData->execute([$_SESSION['userId']]);
        $userData = $userData->fetch(PDO::FETCH_ASSOC);
        $typeSignUp = $userData['user_type'];
    } else {
        $typeSignUp = 0;
    }
?>
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="card-header bg-transparent">
                  <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                  <?php 
                      unset($_SESSION['error']);
                    } 
                  ?>
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title"><?= $typeSignUp == 2 ? 'Buat Akun Dokter' : 'Sign up' ?></h2>
                        <form method="POST" class="register-form" id="register-form">
                            <input type="hidden" name="user-type" id="user-type" value="<?= $typeSignUp == 2 ? 1 : 0 ?>"/>
                            <div class="form-group">
                                <label for="fullname"><i class="zmdi zmdi-account-box-o"></i></label>
                                <input type="text" name="fullname" id="fullname" placeholder="Masukan Nama Lengkap Anda" required/>
                            </div>
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-fullname"></i></label>
                                <input type="text" name="username" id="username" placeholder="Masukan Username Anda" required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email"  id="email" placeholder="Masukan Email Anda"required/>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="zmdi zmdi-home"></i></label>
                                <input type="text" name="address" id="address" placeholder="Masukan address Anda" required/>
                            </div>
                            <div class="form-group">
                                <label for="city"><i class="zmdi zmdi-city-alt  "></i></label>
                                <input type="text" name="city" id="city" placeholder="Masukan Kota Anda" required/>
                            </div>
                            <div class="form-group">
                                <label for="country"><i class="zmdi zmdi-flag "></i></label>
                                <input type="text" name="country" id="country" placeholder="Masukan Negara Anda" required/>
                            </div>
                            <div class="form-group">
                                <label for="postal-code"><i class="zmdi zmdi-n-2-square "></i></label>
                                <input type="number" name="postal-code" id="postal-code" placeholder="Masukan Kode POS Anda" required/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Masukan Password Anda" required/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Masukan kembali password anda" required/>
                            </div>
                            <p>Tulis Bio</p>
                            <div class="form-group">
                                <textarea rows="4" class="form-control" name="bio" placeholder="Beberapa kata tentang dirimu ...  "></textarea>
                            </div>
                            <p> Masukan Tanggal Lahir</p>
                            <div class="form-group">
                                <label for="date"><i class="zmdi zmdi-calendar"></i></label>
                                <input type="date" name="birth-date" id="date" placeholder="Masukan Tanggal Lahir Anda"required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>Saya Menyetujusi Seluruh  <a href="#" class="term-service">Kebijakan yang Berlaku</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="signin.php" class="signup-image-link">Saya sudah terdaftar</a>
                    </div>
                </div>
            </div>
        </section>
        
<?php require_once 'footer_login.php'; ?>