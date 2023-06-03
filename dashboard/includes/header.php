<?php

require_once '../includes/init.php';
Auth::requireLogin();

// header('Cache-Control: no-cache');

$db = new Database();
$conn = $db->getConn();

require 'includes/edit-device-name.php';

// $data = Esp_ID::getAllByUSERID($conn, $_SESSION['user_id']);
$data = Esp_ID::getAllESPID($conn, '*', "array");
// var_dump($data);exit;
$activedevice;
$custom_pages = Custom_page::getByUSERID($conn, $_SESSION['user_id']);

// if (isset($_GET['id'])) {
//   if (!Auth::canView($_GET['id'], $data)) Auth::block();
// }

$email = User::getEmail($conn, $_SESSION['user_id']);
// var_dump($email);exit;
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NYH Smart temp</title>
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


</head>

<body class="hold-transition light-mode sidebar-mini layout-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="includes/img/LOGO.png" alt="NYH Smart temp LOGO" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
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
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="includes/img/LOGO.png" alt="NYH Smart temp Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-dark">NYH Smart temp</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar sidebar-primary">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-1 mb-1 d-flex">
          <div class="image">
            <i class="fa-solid fa-user-large"></i>
          </div>
          <div class="info">
            <a href='profile.php' class='d-block'> . <?= $email["email"]; ?> . </a>
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
                  My Profile
                </p>
              </a>
            </li>

            <?php if ($email["position"] == "admin") ?>
            <li class="nav-item">
              <a href="profile.php" class="nav-link">
                <i class="nav-icon fa-solid fa-user-plus"></i>
                <p>
                  Add user
                </p>
              </a>
            </li>
            <php endif; ?>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">