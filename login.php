<?php

require 'includes/init.php';

if (Auth::isLoggedIn()) {
    Url::redirect('/dashboard');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();
    $conn = $db->getConn();

    $user_id = User::authenticate($conn, $_POST['email'], $_POST['password']);
    if ($user_id > 0) {
        //var_dump($id);
        Auth::login($user_id);
        Url::redirect('/dashboard');
    } else {
        $error = $user_id;
        Auth::saveLogNoAuth("loginpage:" . $user_id);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IoT NYH Laboratory | Log in</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dashboard/includes/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dashboard/includes/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>IoT NYH Laboratory</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">เข้าสู่ระบบเพื่อเข้าใช้งาน</p>

                <?php if (!empty($error)) : ?>
                    <div class="alert alert-warning" role="alert">
                    </i><?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="อีเมลล์">
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
                    <div class="row">
                        <div class="col-4 mx-auto">
                            <button type="submit" class="btn btn-primary btn-block">เข้าสู่ระบบ</button>
                        </div>
                    </div>
                </form>
                <!-- <p class="mb-0">
                    <a href="signup.php" class="text-center">สมัครสมาชิกใหม่</a>
                </p> -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="dashboard/includes/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="dashboard/includes/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
</body>

</html>