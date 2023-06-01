<?php

require 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // var_dump($_POST);
    // exit;

    if (!empty($_POST['email'])) {
        $user = new User();
        $user->user_id = $_SESSION['user_id'];
        $user->email = $_POST['email'];

        if (
            !empty($_POST['pass']) && !empty($_POST['newpass']) && !empty($_POST['newpass2'])
            && $_POST['newpass'] == $_POST['newpass2']
            && User::authenticate($conn, $_POST['email'], $_POST['pass'])
        ) {
            $user->pass = $_POST['newpass'];
        }
    }

    if ($user->update($conn)) {
        if (isset($user->pass)) {
            $update = "บันทึกอีเมลล์และรหัสผ่านแล้ว";
        } else {
            $update = "บันทึกอีเมลล์แล้ว";
        }
    } else {
        $fail = "บันทึกข้อมูลไม่สำเร็จ";
    }
}

?>

<script type="text/javascript">
  document.title = "<?= "Profile | IoTkiddie Dashboard" ?>"
</script>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profile
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <?php if (isset($update)) : ?>
            <div class="alert alert-success" role="alert">
                </i><?= $update ?>
            </div>
        <?php endif; ?>

        <?php if (isset($fail)) : ?>
            <div class="alert alert-danger" role="alert">
                </i><?= $fail ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6 px-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User</h3>
                    </div>

                    <!-- auto fill style -->
                    <style>
                        input:-webkit-autofill,
                        input:-webkit-autofill:hover,
                        input:-webkit-autofill:focus,
                        input:-webkit-autofill:active {
                            transition: background-color 5000s ease-in-out 0s;
                        }
                    </style>

                    <form method="post">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">อีเมลล์</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control  form-control-border" id="email" name="email" placeholder="Email" value="<?= $email ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pass" class="col-sm-4 col-form-label">รหัสผ่านเก่า</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control form-control-border" id="pass" name="pass" placeholder="ใส่เมื่อต้องการเปลี่ยน">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="newpass" class="col-sm-4 col-form-label">ตั้งรหัสผ่านใหม่</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control form-control-border" id="newpass" name="newpass" placeholder="ใส่เมื่อต้องการเปลี่ยน">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="newpass2" class="col-sm-4 col-form-label">ยืนรหัสผ่านใหม่</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control form-control-border" id="newpass2" name="newpass2" placeholder="ใส่เมื่อต้องการเปลี่ยน">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">บันทึก</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("a[href='profile.php']").addClass("active");
    });
</script>