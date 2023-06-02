<?php require 'includes/header.php'; ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">อุปกรณ์ของคุณทั้งหมด</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Device</li>
          <!-- <li class="breadcrumb-item active">Dashboard</li> -->
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">

      <?php if (!empty($data)) : ?>
        <?php foreach ($data as $device) : ?>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1">

                <?php if ($device['project_id'] == 4) : ?>
                  <i class="fa-solid fa-temperature-half"></i>
                <?php else : ?>
                  <i class="fa-solid fa-wifi"></i>
                <?php endif; ?>

              </span>
              <div class="info-box-content">
                <span class="info-box-text"><a href="device.php?id=<?= $device['esp_id']; ?>"><?= (is_null($device['device_name']) ? $device['esp_id'] : $device['device_name']); ?></a></span>
                <span class="info-box-number">
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        <?php endforeach; ?>
      <?php endif; ?>

    </div>
    <!-- /.row -->
  </div>
  <!--/. container-fluid -->
</section>

<?php require 'includes/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function() {
    $("a[href='/dashboard']").addClass("active");
  });
</script>