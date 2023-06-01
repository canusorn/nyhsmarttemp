<?php

require($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');


$esp_id = 0;
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'] . "/dashboard") && isset($_REQUEST['id'])) {

        // >>>> Security check
        if (empty($_SESSION['skey']) || empty($_POST['skey']) || ($_SESSION['skey'] != $_POST['skey'])) {
            Auth::block();
        } else {
            // echo "AJAX request";
            $esp_id = $_REQUEST['id'];
        }
    } else if (!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'] . "/preview")) {
        $esp_id = 4719397;
    } else {
        Auth::block();
    }
} else {
    Auth::block();
}


if ($esp_id) {
    try {
        if (isset($_REQUEST['point'])) {
            if (isset($_REQUEST['data']) && $_REQUEST['data'] == "sec") {
                $results = Data_1_sec::getLastMulti($esp_id, $_REQUEST['point']);

                //get minimize
                date_default_timezone_set('Asia/Bangkok');
                $date = new Datetime();
                $min_energy = Data_1_sec::getMinEnergy($esp_id, $date->format('Y-m-d'));
                $db = new Database();
                $conn = $db->getConn();
                $lastupdate = Esp_ID::getByESPID($conn, $esp_id)->lastupdate;
                try {
                    $last30day = Data_1_day::getLastCostom($esp_id, "1 months", "SUM(energy)");
                } catch (Throwable $e) {
                }
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "min") {
                $results = Data_1_min::getLastMulti($esp_id, $_REQUEST['point']);
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "hr") {
                $results = Data_1_hr::getLastMulti($esp_id, $_REQUEST['point']);
            } else { // get day data
            }
        } else if (isset($_REQUEST['range'])) {
            // if (isset($_REQUEST['data']) && $_REQUEST['data'] == "sec") {
            //     $results = Data_1_sec::getRange($esp_id, $_REQUEST['point']);
            // } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "min") {
            //     $results = Data_1_min::getLastMulti($esp_id, $_REQUEST['point']);
            // } else 
            if (isset($_REQUEST['data']) && $_REQUEST['data'] == "sec") {
                if (isset($_REQUEST['range']['start2'])) {
                    $results = Data_1_sec::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
                    $results2 = Data_1_sec::getRange($esp_id, $_REQUEST['range']['start2'], $_REQUEST['range']['end2']);
                } else if (isset($_REQUEST['range']['start']))
                    $results = Data_1_sec::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "min") {
                if (isset($_REQUEST['range']['start2'])) {
                    $results = Data_1_min::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
                    $results2 = Data_1_min::getRange($esp_id, $_REQUEST['range']['start2'], $_REQUEST['range']['end2']);
                } else if (isset($_REQUEST['range']['start']))
                    $results = Data_1_min::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "hr") {
                if (isset($_REQUEST['range']['start2'])) {
                    $results = Data_1_hr::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
                    $results2 = Data_1_hr::getRange($esp_id, $_REQUEST['range']['start2'], $_REQUEST['range']['end2']);
                } else if (isset($_REQUEST['range']['start']))
                    $results = Data_1_hr::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "day") {
                if (isset($_REQUEST['range']['start2'])) {
                    $results = Data_1_day::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
                    $results2 = Data_1_day::getRange($esp_id, $_REQUEST['range']['start2'], $_REQUEST['range']['end2']);
                } else if (isset($_REQUEST['range']['start']))
                    $results = Data_1_day::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
            }
        }
    } catch (Throwable $e) {
        die("nodata");
    }
}

if (isset($results2)) {
    $voltage = [];
    $current = [];
    $power = [];
    $energy = [];
    $frequency = [];
    $pf = [];
    $time = [];
    $voltage2 = [];
    $current2 = [];
    $power2 = [];
    $energy2 = [];
    $frequency2 = [];
    $pf2 = [];
    $time2 = [];
    foreach ($results as $result) {
        $voltage[] = number_format((float)$result['voltage'], 1, '.', '');
        $current[] = number_format((float)$result['current'], 3, '.', '');
        $power[] = number_format((float)$result['power'], 1, '.', '');
        $energy[] = number_format((float)$result['energy'], 3, '.', '');
        $frequency[] = number_format((float)$result['frequency'], 1, '.', '');
        $pf[] = number_format((float)$result['pf'], 2, '.', '');
        $time[] = $result['time'];
    }
    foreach ($results2 as $result2) {
        $voltage2[] = number_format((float)$result2['voltage'], 1, '.', '');
        $current2[] = number_format((float)$result2['current'], 3, '.', '');
        $power2[] = number_format((float)$result2['power'], 1, '.', '');
        $energy2[] = number_format((float)$result2['energy'], 3, '.', '');
        $frequency2[] = number_format((float)$result2['frequency'], 1, '.', '');
        $pf2[] = number_format((float)$result2['pf'], 2, '.', '');
        $time2[] = $result2['time'];
    }
    $data = array(
        "voltage" => $voltage, "current" => $current, "power" => $power, "energy" => $energy, "frequency" => $frequency, "pf" => $pf, "time" => $time,
        "voltage2" => $voltage2, "current2" => $current2, "power2" => $power2, "energy2" => $energy2, "frequency2" => $frequency2, "pf2" => $pf2, "time2" => $time2
    );

    echo json_encode($data);
} else if (isset($results)) {
    $voltage = [];
    $current = [];
    $power = [];
    $energy = [];
    $frequency = [];
    $pf = [];
    $time = [];
    foreach ($results as $result) {
        $voltage[] = number_format((float)$result['voltage'], 1, '.', '');
        $current[] = number_format((float)$result['current'], 3, '.', '');
        $power[] = number_format((float)$result['power'], 1, '.', '');
        $energy[] = number_format((float)$result['energy'], 3, '.', '');
        $frequency[] = number_format((float)$result['frequency'], 1, '.', '');
        $pf[] = number_format((float)$result['pf'], 2, '.', '');
        $time[] = $result['time'];
    }
    $data = array("voltage" => $voltage, "current" => $current, "power" => $power, "energy" => $energy, "frequency" => $frequency, "pf" => $pf, "time" => $time);
    if (isset($min_energy)) {
        $data += ["min_energy" => $min_energy];
    }
    if (isset($lastupdate) && !is_null($lastupdate)) {
        $data += ["lastupdate" => $lastupdate];
    }
    if (isset($last30day)) {
        $data += ["sum_e" => $last30day[0]['SUM(energy)']];
    }
    // var_dump(json_encode($data));
    echo json_encode($data);
    // echo json_encode($_REQUEST);
}
