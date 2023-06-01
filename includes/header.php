<!DOCTYPE html>
<html class="h-100">

<head>
    <title>IoT Temperature</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/includes/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .features-icons {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
    </style>

    <!-- Custom styles for this template -->
    <!-- <link href="../css/cover.css" rel="stylesheet"> -->
     
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- <div class="navbar-header"> -->
            <a class="navbar-brand" href="/"><img src="includes/img/LOGO.png" alt="" width="50">IoT kiddie</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- </div> -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="/preview">Live preview</a></li>
                    <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
                    <li class="nav-item"><a href="https://www.iotbundle.com/contactus" target="_blank" class="nav-link">ช่องทางติดต่อ</a></li>
                    <?php if (Auth::isLoggedIn()) : ?>
                        <li class="nav-item"><a class="nav-link" href="/dashboard/">แดชบอร์ด</a></li>
                        <li class="nav-item"><a class="nav-link" href="/logout.php">ออกจากระบบ</a></li>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link" href="/login.php">เข้าสู่ระบบ</a></li>
                        <!-- <li class="nav-item"><a class="btn btn-outline-primary" href="/signup.php">สมัครสมาชิกใหม่</a></li> -->
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>



    <main class="">