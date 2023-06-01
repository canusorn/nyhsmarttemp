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
            <div class="col-auto" id="value">
                <div class="card">
                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay dark">
                        <i class="fas fa-3x fa-sync-alt"></i>
                        <h3></h3>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title">ค่าล่าสุด</h4>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-light" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ./card-body -->
                    <div class="card-body">
                        <div class="container">
                            <h4><svg xmlns="http://www.w3.org/2000/svg" height="1.5rem" fill="currentColor" class="bi bi-1-square" viewBox="0 0 16 16">
                                    <path d="M9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z" />
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z" />
                                </svg> Phase1</h4>
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> -->
                                        <h5 class="description-header mb-2" id="voltage1"></h5>
                                        <span class="description-text">Voltage [v]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block ">
                                        <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> -->
                                        <h5 class="description-header mb-2" id="current1"></h5>
                                        <span class="description-text">Current [A]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span> -->
                                        <h5 class="description-header mb-2" id="power1"></h5>
                                        <span class="description-text">Power [W]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="energy1"></h5>
                                        <span class="description-text">Today Energy [kWh]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="frequency1"></h5>
                                        <span class="description-text">Frequency [Hz]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <div class="col-md-2 col-4 ">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="pf1"></h5>
                                        <span class="description-text">power factor</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>

                            <!-- <div class="row justify-content-center">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <span class="description-percentage"><i class="fa-solid fa-wallet"></i> ค่าไฟวันนี้</span>
                                        <h5 class="description-header mb-2 mt-3" id="bill1_111"></h5>
                                        <h5 class="description-header mb-2" id="bill1_112"></h5>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <span class="description-percentage"><i class="fa-solid fa-wallet"></i> ค่าไฟ30วันล่าสุด</span>
                                        <h5 class="description-header mb-2 mt-3" id="bill1_111_mouth"></h5>
                                        <h5 class="description-header mb-2" id="bill1_112_mouth"></h5>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="container mt-5">
                            <h4><svg xmlns="http://www.w3.org/2000/svg" height="1.5rem" fill="currentColor" class="bi bi-2-square" viewBox="0 0 16 16">
                                    <path d="M6.646 6.24v.07H5.375v-.064c0-1.213.879-2.402 2.637-2.402 1.582 0 2.613.949 2.613 2.215 0 1.002-.6 1.667-1.287 2.43l-.096.107-1.974 2.22v.077h3.498V12H5.422v-.832l2.97-3.293c.434-.475.903-1.008.903-1.705 0-.744-.557-1.236-1.313-1.236-.843 0-1.336.615-1.336 1.306Z" />
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z" />
                                </svg> Phase2</h4>
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> -->
                                        <h5 class="description-header mb-2" id="voltage2"></h5>
                                        <span class="description-text">Voltage [v]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block ">
                                        <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> -->
                                        <h5 class="description-header mb-2" id="current2"></h5>
                                        <span class="description-text">Current [A]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span> -->
                                        <h5 class="description-header mb-2" id="power2"></h5>
                                        <span class="description-text">Power [W]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="energy2"></h5>
                                        <span class="description-text">Today Energy [kWh]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="frequency2"></h5>
                                        <span class="description-text">Frequency [Hz]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <div class="col-md-2 col-4 ">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="pf2"></h5>
                                        <span class="description-text">power factor</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- <div class="row justify-content-center">
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <span class="description-percentage"><i class="fa-solid fa-wallet"></i> ค่าไฟวันนี้</span>
                                        <h5 class="description-header mb-2 mt-3" id="bill2_111"></h5>
                                        <h5 class="description-header mb-2" id="bill2_112"></h5>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <span class="description-percentage"><i class="fa-solid fa-wallet"></i> ค่าไฟ30วันล่าสุด</span>
                                        <h5 class="description-header mb-2 mt-3" id="bill2_111_mouth"></h5>
                                        <h5 class="description-header mb-2" id="bill2_112_mouth"></h5>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="container mt-5">
                            <h4><svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" fill="currentColor" class="bi bi-3-square" viewBox="0 0 16 16">
                                    <path d="M7.918 8.414h-.879V7.342h.838c.78 0 1.348-.522 1.342-1.237 0-.709-.563-1.195-1.348-1.195-.79 0-1.312.498-1.348 1.055H5.275c.036-1.137.95-2.115 2.625-2.121 1.594-.012 2.608.885 2.637 2.062.023 1.137-.885 1.776-1.482 1.875v.07c.703.07 1.71.64 1.734 1.917.024 1.459-1.277 2.396-2.93 2.396-1.705 0-2.707-.967-2.754-2.144H6.33c.059.597.68 1.06 1.541 1.066.973.006 1.6-.563 1.588-1.354-.006-.779-.621-1.318-1.541-1.318Z" />
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z" />
                                </svg> Phase3</h4>
                            <div class="row">
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span> -->
                                        <h5 class="description-header mb-2" id="voltage3"></h5>
                                        <span class="description-text">Voltage [v]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block ">
                                        <!-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> -->
                                        <h5 class="description-header mb-2" id="current3"></h5>
                                        <span class="description-text">Current [A]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span> -->
                                        <h5 class="description-header mb-2" id="power3"></h5>
                                        <span class="description-text">Power [W]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="energy3"></h5>
                                        <span class="description-text">Today Energy [kWh]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <div class="col-md-2 col-4">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="frequency3"></h5>
                                        <span class="description-text">Frequency [Hz]</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <div class="col-md-2 col-4 ">
                                    <div class="description-block">
                                        <!-- <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span> -->
                                        <h5 class="description-header mb-2" id="pf3"></h5>
                                        <span class="description-text">power factor</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                        </div>
                        <div class="container mt-5">
                            <h4><i class="fa-solid fa-wallet"></i> ประมาณการค่าไฟฟ้า</h4>
                            <div class="row justify-content-center">
                                <div class="col">
                                    <div class="description-block">
                                        <span class="description-percentage">ค่าไฟวันนี้</span>
                                        <div class="container">
                                            <div class="row justify-content-center">
                                                <div class="col">
                                                    <h6 class="description-header mb-2 mt-3">Phase1</h6>
                                                    <h6 class="description-header mb-2" id="energy1_day"></h6>
                                                    <h6 class="description-header mb-2" id="bill1_111"></h6>
                                                    <h6 class="description-header mb-2" id="bill1_112"></h6>
                                                </div>
                                                <div class="col">
                                                    <h6 class="description-header mb-2 mt-3">Phase2</h6>
                                                    <h6 class="description-header mb-2" id="energy2_day"></h6>
                                                    <h6 class="description-header mb-2" id="bill2_111"></h6>
                                                    <h6 class="description-header mb-2" id="bill2_112"></h6>
                                                </div>
                                                <div class="col">
                                                    <h6 class="description-header mb-2 mt-3">Phase3</h6>
                                                    <h6 class="description-header mb-2" id="energy3_day"></h6>
                                                    <h6 class="description-header mb-2" id="bill3_111"></h6>
                                                    <h6 class="description-header mb-2" id="bill3_112"></h6>
                                                </div>
                                                <div class="col">
                                                    <h6 class="description-header mb-2 mt-3">AllPhase</h6>
                                                    <h5 class="description-header mb-2" id="energy_day"></h5>
                                                    <h5 class="description-header mb-2" id="bill_111"></h5>
                                                    <h5 class="description-header mb-2" id="bill_112"></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="description-block">
                                        <div class="col">
                                            <div class="description-block">
                                                <span class="description-percentage">ค่าไฟ30วันล่าสุด</span>
                                                <div class="container">
                                                    <div class="row justify-content-center">
                                                        <div class="col">
                                                            <h6 class="description-header mb-2 mt-3">Phase1</h6>
                                                            <h6 class="description-header mb-2 mt-3" id="energy1_month"></h6>
                                                            <h6 class="description-header mb-2 mt-3" id="bill1_111_mouth"></h6>
                                                            <h6 class="description-header mb-2" id="bill1_112_mouth"></h6>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="description-header mb-2 mt-3">Phase2</h6>
                                                            <h6 class="description-header mb-2 mt-3" id="energy2_month"></h6>
                                                            <h6 class="description-header mb-2 mt-3" id="bill2_111_mouth"></h6>
                                                            <h6 class="description-header mb-2" id="bill2_112_mouth"></h6>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="description-header mb-2 mt-3">Phase3</h6>
                                                            <h6 class="description-header mb-2 mt-3" id="energy3_month"></h6>
                                                            <h6 class="description-header mb-2 mt-3" id="bill3_111_mouth"></h6>
                                                            <h6 class="description-header mb-2" id="bill3_112_mouth"></h6>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="description-header mb-2 mt-3">AllPhase</h6>
                                                            <h5 class="description-header mb-2 mt-3" id="energy_month"></h5>
                                                            <h5 class="description-header mb-2 mt-3" id="bill_111_mouth"></h5>
                                                            <h5 class="description-header mb-2" id="bill_112_mouth"></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer" id="time"></div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
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
                        <h5 class="card-title" id="chart_name">ค่ากำลังไฟฟ้าล่าสุด [watt]</h5>

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
                                    <canvas id="Chart_1" height="300" style="height: 300px;"></canvas>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="chart" id="Chart2">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="Chart_2" height="300" style="height: 300px;"></canvas>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="chart" id="Chart3">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="Chart_3" height="300" style="height: 300px;"></canvas>
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
                                    <div id="areaChart1" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></div>
                                    <div class="mt-5" id="areaChart2" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></div>
                                    <div class="mt-5" id="areaChart3" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></div>
                                </div>
                            </div>
                        </div>
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
                            <label class="form-check-label" for="dailynotify" data-toggle="tooltip" title="แจ้งตอนเที่ยงคืนของทุกวัน">แจ้งเตือนหน่วยไฟฟ้าที่ใช้ประจำวัน [kWh]</label>
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
                            <h3>0.0.<?= number_format($activedevice['version'] *0.1,1) ?></h3>
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
                                    skey: '<?= $_SESSION['skey']; ?>',
                                    p_id: 1
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
                            } else if (<?= $activedevice['need_ota'] ?> == 2) {
                                $.post('ajax/version.php', {
                                    skey: '<?= $_SESSION['skey']; ?>',
                                    p_id: 1
                                }).done(function(v) {
                                    // console.log(v);
                                    if (v == <?= $activedevice['version'] ?>) {
                                        // console.log($(this).text());
                                        const urlParams = new URLSearchParams(window.location.search);
                                        const id = urlParams.get('id');
                                        // console.log(id);
                                        $.post('ajax/version.php', {
                                            id: id,
                                            skey: '<?= $_SESSION['skey']; ?>',
                                            updated: 1
                                        }).done(function(data) {
                                            $('#ota-form .small-box .small-box-footer').addClass('bg-success').removeClass('bg-warning bg-info');
                                            data = "เวอร์ชั่นล่าสุดแล้ว <i class=\"fa-solid fa-circle-check\"></i>"
                                            $('#ota-form .small-box .small-box-footer').html(data);
                                        });
                                    } else {
                                        $('#ota-form .small-box .small-box-footer').addClass('bg-info').removeClass('bg-warning bg-success');
                                    }
                                });
                            } else {
                                $('#ota-form .small-box .small-box-footer').addClass('bg-info').removeClass('bg-warning bg-success');
                            }
                        });
                    });
                </script>
            <?php endif; ?>



        </div>
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
<script type="text/javascript" src="js/ebill.js?n=2"></script>
<script type="text/javascript" src="js/06acmeter_3p.js?n=3"></script>