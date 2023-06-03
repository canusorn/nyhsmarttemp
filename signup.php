<?php

require 'includes/init.php';

if (!Auth::isLoggedIn()) {
    Url::redirect('/login');
}

$user = new User();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // var_dump($_POST);exit;

    $db = new Database();
    $conn = $db->getConn();

    $user->email = $_POST['email'];
    $user->pass = $_POST['password'];
    $user->pass2 = $_POST['password2'];
    if(isset($_POST['terms'])){$user->terms_agreed = $_POST['terms'];}

    try {
        if ($user->create($conn)) {
            // Auth::login($user->user_id);
            Url::redirect('/dashboard');
        }
    } catch (Exception $e) {
        if ($e->getCode() == 23000) {
            $user->errors[] = "อีเมลล์นี้ได้สมัครไว้แล้ว";
        } else {
            $user->errors[] = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NYH Smart | เพิ่มสมาชิกใหม่</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dashboard/includes/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="dashboard/includes/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dashboard/includes/dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="../../index.php"><b>เพิ่มสมาชิกใหม่</b></a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">สมาชิกใหม่</p>

                <?php if (!empty($user->errors)) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?php foreach ($user->errors as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="อีเมลล์" value="<?= $user->email ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password2" placeholder="ยีนยันรหัสผ่านอีกครับ">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    ฉันยอมรับเงือนไข
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4 mb-2">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> -->

                <!-- <a href="login.php" class="text-center">เป็นสมาชิกอยู่แล้ว</a> -->
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>