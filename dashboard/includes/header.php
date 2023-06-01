<?php

require_once '../includes/init.php';
Auth::requireLogin();

// header('Cache-Control: no-cache');

$db = new Database();
$conn = $db->getConn();

require 'includes/edit-device-name.php';

$data = Esp_ID::getAllByUSERID($conn, $_SESSION['user_id']);
$activedevice;
$custom_pages = Custom_page::getByUSERID($conn, $_SESSION['user_id']);
// var_dump($custom_pages);
// exit;
// var_dump($data);exit;

if (isset($_GET['id'])) {
  if (!Auth::canView($_GET['id'], $data)) Auth::block();
}

$email = User::getEmail($conn, $_SESSION['user_id']);
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IoTkiddie Dashboard</title>
  <link rel="icon" type="image/x-icon" href="/includes/img/favicon.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="includes/plugins/fontawesome-free/css/all.min.css"> -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="includes/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="includes/dist/css/adminlte.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css"> -->
  <!-- jQuery -->
  <script src="includes/plugins/jquery/jquery.min.js"></script>
  <!-- Daterange picker -->
  <link rel="stylesheet" href="includes/plugins/daterangepicker/daterangepicker.css">
  <!-- uPlot -->
  <link rel="stylesheet" href="includes/plugins/uplot/uPlot.min.css">
  <!-- data table -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"> -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
  <!-- jQuery Timepicker -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-DL7SLX331N"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-DL7SLX331N');
  </script>


  <!-- Hotjar Tracking Code for https://iotkiddie.com/ -->
  <script>
    (function(h, o, t, j, a, r) {
      h.hj = h.hj || function() {
        (h.hj.q = h.hj.q || []).push(arguments)
      };
      h._hjSettings = {
        hjid: 2958070,
        hjsv: 6
      };
      a = o.getElementsByTagName('head')[0];
      r = o.createElement('script');
      r.async = 1;
      r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
      a.appendChild(r);
    })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
  </script>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-0756310495183910"
     crossorigin="anonymous"></script>
     
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="includes/img/LOGO.png" alt="IoTbundle LOGO" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/" class="nav-link">หน้าแรก</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/dashboard" class="nav-link active">แดชบอร์ด</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="../blog/docs/" target="_blank" class="nav-link">วิธีใช้งาน</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="https://www.iotbundle.com/contactus" target="_blank" class="nav-link">ติดต่อ</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="https://forms.gle/YjCyEFPFx94FFt5E6" target="_blank" class="nav-link">Feedback</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="https://fastwork.co/user/canusorn" target="_blank" class="nav-link">เขียนโค้ด</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="includes/img/LOGO.png" alt="IoTkiddie Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">IoTkiddie</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-1 mb-1 d-flex">
          <div class="image">
            <i class="fa-solid fa-user-large"></i>
          </div>
          <div class="info">
            <?php if (empty($data)) : {

                echo ("<a href='profile.php' class='d-block'>" . $email . "</a>");
              } ?>
            <?php else : ?>
              <a href='profile.php' class='d-block'>
                <?= $data[0]['email'] ?></a>
            <?php endif; ?>
            <div class="d-block">
              <a href="../logout.php" class="pt-2">
                <i class="fa-solid fa-right-from-bracket"></i>
                Log out</a>
            </div>
          </div>

        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <!-- <li class="nav-header">Device</li> -->
            <li class="nav-item">
              <a href="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Device
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <!-- Device dashboard -->
              <?php if (!empty($data)) : ?>
                <?php foreach ($data as $device) : ?>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <?php if (isset($_GET['id']) && $_GET['id'] == $device['esp_id']) : ?>
                        <a href="device.php?id=<?= $device['esp_id']; ?>" class="nav-link active">
                          <?php
                          (is_null($device['device_name']) ? $device['esp_id'] : $device['device_name']);
                          $activedevice = $device;
                          ?>

                        <?php else : ?>
                          <a href="device.php?id=<?= $device['esp_id']; ?>" class="nav-link">
                          <?php endif; ?>
                          <i class="far fa-circle nav-icon"></i>
                          <?= (is_null($device['device_name']) ? $device['esp_id'] : $device['device_name']); ?>
                          </a>
                    </li>
                  </ul>
                <?php endforeach; ?>
              <?php endif; ?>
            </li>
            <?php foreach ($custom_pages as $page) : ?>
              <li class="nav-item">
                <a href="customdashboard.php?p=<?= $page['id']; ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-calculator"></i>
                  <p>
                    <?= $page['page']; ?>
                  </p>
                </a>
              </li>
            <?php endforeach; ?>
            <li class="nav-item">
              <a href="profile.php" class="nav-link">
                <i class="nav-icon fas fa-solid fa-address-card"></i>
                <p>
                  Profile
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- ประกาศ -->
      <!-- <div class="alert alert-info alert-dismissible fade show m-1" role="alert">
        ตอนนี้ยังเป็น <strong>เวอร์ชั่นเบต้า!</strong> การใช้งานอาจจะมีบัคหรือติดขัดบ้างนะครับ ทางเรากำลังพัฒนาอย่างเต็มที่ เพื่อเพิ่มฟังก์ชั่นอีกมากมาย ขอบคุณที่ทุกท่านที่ให้การสนับสนุนครับ
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->