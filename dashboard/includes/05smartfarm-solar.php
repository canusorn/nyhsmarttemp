<?php

if (!isset($activedevice)) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');
    $db = new Database();
    $conn = $db->getConn();

    $activedevice = Esp_ID::getByESPID($conn, $_POST['id'],'*',"array");
}

?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">


        <div class="d-inline-flex flex-column">
            <div class="btn-group btn-group-toggle mb-3 " data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="options" id="overview_option" href="#overview" autocomplete="off" checked> ภาพรวม
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" id="history_option" autocomplete="off"> ประวัติย้อนหลัง
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" id="setting_option" autocomplete="off"> ตั้งค่าอุปกรณ์
                </label>
            </div>
        </div>


        <div class="row">

            <div class="col-auto col-md-8" id="value">
                <div class="card">
                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                        <h3></h3>
                    </div>
                    <!-- end loading -->
                    <div class="card-header">
                        <h5 class="card-title">ค่าล่าสุด</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- ./card-body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="description-block ">
                                    <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> -->
                                    <h5 class="description-header mb-2" id="humid"></h5>
                                    <span class="description-text">ความชื้น</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col">
                                <div class="description-block ">
                                    <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> -->
                                    <h5 class="description-header mb-2" id="temp"></h5>
                                    <span class="description-text">อุณหภูมิ</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <div class="col">
                                <div class="description-block ">
                                    <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> -->
                                    <h5 class="description-header mb-2" id="valve"></h5>
                                    <span class="description-text">Valve</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <div class="col">
                                <div class="description-block ">
                                    <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> -->
                                    <h5 class="description-header mb-2" id="vbatt"></h5>
                                    <span class="description-text">Vbatt</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="card-footer" id="time"></div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-sm-4" id="io">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">เปิดปิด OUTPUT</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D0" onclick="iowrite()">
                                        <label class="custom-control-label" for="D0">D0</label>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D1" onclick="iowrite()">
                                        <label class="custom-control-label" for="D1">D1</label>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D2" onclick="iowrite()">
                                        <label class="custom-control-label" for="D2">D2</label>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D3" onclick="iowrite()">
                                        <label class="custom-control-label" for="D3">D3</label>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D4" onclick="iowrite()">
                                        <label class="custom-control-label" for="D4">D4</label>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D5" onclick="iowrite()">
                                        <label class="custom-control-label" for="D5">D5</label>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D6" onclick="iowrite()">
                                        <label class="custom-control-label" for="D6">D6</label>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D7" onclick="iowrite()">
                                        <label class="custom-control-label" for="D7">D7</label>
                                    </div>
                                </div>
                                <div class="form-group ml-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="D8" onclick="iowrite()">
                                        <label class="custom-control-label" for="D8">D8</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>



        <div class="row">
            <div class="col-md-12" id="chart">
                <div class="card">
                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                        <h3></h3>
                    </div>
                    <!-- end loading -->
                    <div class="card-header">
                        <h5 class="card-title" id="chart_name">อุณหภูมิล่าสุด</h5>
                        <div class="card-tools history_option_class">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item day_view_class p-1"><a class="nav-link active" id="day_view" href="#Chart1" data-toggle="tab">รายวัน</a></li>
                                <li class="nav-item day_view_class p-1"><a class="nav-link" id="mouth_view" href="#Charthistory" data-toggle="tab">เดือน</a></li>
                                <li class="nav-item day_view_class p-1 pr-2"><a class="nav-link" id="history_view" href="#uplot" data-toggle="tab">ย้อนหลัง</a></li>


                                <button type="button" id="csvdownload" class="btn btn-outline-secondary text-light btn-sm  history_view_class" title="download csv file">
                                    <i class="fa-solid fa-download"></i>&nbsp;<span>CSV</span>
                                </button>
                                <button type="button" class="btn btn-outline-secondary text-light btn-sm daterange history_view_class" title="Date range">
                                    <i class="far fa-calendar-alt"></i>&nbsp;<span></span>
                                </button>
                                <button type="button" class="btn btn-tool history_view_class" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </ul>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart" id="Chart1">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="ssChart" height="300" style="height: 300px;"></canvas>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                        </div>
                        <!-- /.row -->

                        <!-- /.card-header -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart" id="Charthistory">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="Chart_history" height="300" style="height: 300px;"></canvas>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart" id="uplot">
                                    <div id="areaChart" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-md-12" id="google_table">
                <div class="card">

                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                        <h3></h3>
                    </div>
                    <!-- end loading -->

                    <div class="card-header">
                        <h5 class="card-title">table</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-dark">
                        <div id="table_div" class="text-dark"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 setting-page" id="setting-form">

                <!-- setting form -->
                <div class="card">

                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                        <h3></h3>
                    </div>
                    <!-- end loading -->

                    <div class="card-header">
                        <h5 class="card-title">Line</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-dark">

                        <div class="form-group" id="getLineToken">
                            <label for="linetoken" data-toggle="tooltip" title="Token ที่ได้จาก Line notify"><i class="fa-brands fa-line"></i> Line Token <a target="_blank" href="linetoken_get.php?id=<?= $_GET['id'] ?>">สมัครรับโทเค็น</a></label>
                            <input type="text" class="form-control" id="linetoken" placeholder="Line token">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="dailynotify">
                            <label class="form-check-label" for="dailynotify" data-toggle="tooltip" title="แจ้งตอนเที่ยงคืนของทุกวัน">แจ้งเตือนค่าเฉลี่ยของแต่ละวัน</label>
                        </div>
                        <hr>
                        <div class="form-check mb-2" hidden>
                            <input type="checkbox" class="form-check-input" id="offlinenotify">
                            <label class="form-check-label" for="offlinenotify" data-toggle="tooltip" title="ออฟไลน์เมื่อเกิดเหตุการณ์ไฟดับ เน็ตหลุด หรืออื่นๆ และแจ้งเมื่อกลับมาออนไลน์แล้ว">แจ้งเตือนสถานะอุปกรณ์ online offline</label>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button id="linedata-save" type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>


            <?php if (!is_null($activedevice['version']) && $activedevice['version'] >= 7) : ?>
                <div class="col-lg-3 col-6 setting-page" id="ota-form">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>0.0.<?= $activedevice['version'] ?></h3>
                            <p>เวอร์ชั่นของอุปกรณ์นี้</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-code-compare"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            <?php if ($activedevice['need_ota'] == 0) : ?>
                                Loading<i class="fa-solid fa-circle-up"></i>
                            <?php elseif ($activedevice['need_ota'] == 1 || $activedevice['need_ota'] == 2) : ?>
                                กำลังอัพเดท..<i class="fa-solid fa-circle-up"></i>
                            <?php elseif ($activedevice['need_ota'] == 3) : ?>
                                อัพเดทไม่สำเร็จ<i class="fa-solid fa-circle-xmark"></i>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#setting_option").click(function() {
                            if (<?= $activedevice['need_ota'] ?> == 0 || <?= $activedevice['need_ota'] ?> == 3) {
                                $.post('ajax/version.php', {
                                    // id: id,
                                    skey: '<?= $_SESSION['skey']; ?>',
                                    p_id: 5
                                }).done(function(v) {
                                    // console.log(v);
                                    if (v > <?= $activedevice['version'] ?>) {
                                        $('#ota-form .small-box .small-box-footer').addClass('bg-warning').removeClass('bg-success bg-info');
                                        data = "อัพเดทเวอร์ชั่น 0.0." + v + " <i class=\"fa-solid fa-circle-up\"></i>"
                                        $("#ota-form .small-box .small-box-footer").on("click", function() {
                                            // console.log($(this).text());
                                            const urlParams = new URLSearchParams(window.location.search);
                                            const id = urlParams.get('id');
                                            // console.log(id);
                                            $.post('ajax/version.php', {
                                                id: id,
                                                skey: '<?= $_SESSION['skey']; ?>',
                                            }).done(function(data) {
                                                console.log(data);
                                                $('#ota-form .small-box .small-box-footer').addClass('bg-info').removeClass('bg-warning bg-success');
                                                data = "กำลังอัพเดทอุปกรณ์ <i class=\"fa-solid fa-arrows-rotate\"></i>"
                                                $('#ota-form .small-box .small-box-footer').html(data);
                                            });

                                        });
                                    } else {
                                        $('#ota-form .small-box .small-box-footer').addClass('bg-success').removeClass('bg-warning bg-info');
                                        data = "เวอร์ชั่นล่าสุดแล้ว <i class=\"fa-solid fa-circle-check\"></i>"
                                    }
                                    $('#ota-form .small-box .small-box-footer').html(data);
                                });
                            }
                            else{
                                $('#ota-form .small-box .small-box-footer').addClass('bg-info').removeClass('bg-warning bg-success');
                            }
                        });
                    });
                </script>
            <?php endif; ?>


        </div>

        <!-- toast  -->
        <div aria-live="polite" aria-atomic="true" class="position-fixed bottom-5 right-5 p-5 m-3" style="z-index: 5; right: 5px; bottom: 5px;">
            <div class="toast text-white bg-success border-0" data-delay="5000" style="position: absolute; bottom: 0; right: 0;">
                <div class="toast-header">
                    <i class="fa-solid fa-bell"></i>
                    <strong class="mr-auto"> IoTkiddie</strong>
                    <!-- <small>now</small> -->
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    <p id="toast-body"></p>
                </div>
            </div>
        </div>

</section>

<!-- script for real time chart -->
<script>
    var esp_id = <?= $_REQUEST['id'] ?>;
    var sk = '<?= $_SESSION['skey']; ?>';
</script>
<script type="text/javascript" src="js/05smartfarm-solar.js?n=6"></script>