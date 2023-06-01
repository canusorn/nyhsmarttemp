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
                $results = Data_0_sec::getLastMulti($esp_id, $_REQUEST['point']);
                $db = new Database();
                $conn = $db->getConn();
                $lastupdate = Esp_ID::getByESPID($conn, $esp_id)->lastupdate;

                if ($_REQUEST['point'] == 200) {
                    $sec = new Data_0_sec($esp_id);
                    $label = $sec->getLabel();
                }
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "min") {
                $results = Data_0_min::getLastMulti($esp_id, $_REQUEST['point']);
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "hr") {
                $results = Data_0_hr::getLastMulti($esp_id, $_REQUEST['point']);
            } else { // get day data
            }
        } else if (isset($_REQUEST['range'])) {
            if (isset($_REQUEST['data']) && $_REQUEST['data'] == "sec") {
                $results = Data_0_sec::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "min") {
                $results = Data_0_min::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "hr") {
                $results = Data_0_hr::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
            } else if (isset($_REQUEST['data']) && $_REQUEST['data'] == "day") {
                $results = Data_0_day::getRange($esp_id, $_REQUEST['range']['start'], $_REQUEST['range']['end']);
            }
        } else if (isset($_REQUEST['var-name-0'])) {
            // die($_REQUEST['var-name-0']);
            $var = [];
            // foreach ($_REQUEST as $key => $value) {
            if (isset($_REQUEST['var-name-0'])) $var["c0"] = $_REQUEST['var-name-0'];
            if (isset($_REQUEST['var-name-1'])) $var["c1"] = $_REQUEST['var-name-1'];
            if (isset($_REQUEST['var-name-2'])) $var["c2"] = $_REQUEST['var-name-2'];
            if (isset($_REQUEST['var-name-3'])) $var["c3"] = $_REQUEST['var-name-3'];
            if (isset($_REQUEST['var-name-4'])) $var["c4"] = $_REQUEST['var-name-4'];
            if (isset($_REQUEST['var-name-5'])) $var["c5"] = $_REQUEST['var-name-5'];
            if (isset($_REQUEST['var-name-6'])) $var["c6"] = $_REQUEST['var-name-6'];
            if (isset($_REQUEST['var-name-7'])) $var["c7"] = $_REQUEST['var-name-7'];
            if (isset($_REQUEST['var-name-8'])) $var["c8"] = $_REQUEST['var-name-8'];
            if (isset($_REQUEST['var-name-9'])) $var["c9"] = $_REQUEST['var-name-9'];
            // }

            // print_r($var);
            // echo(json_encode($var));

            $data = new Data_0_sec($esp_id);
            echo $data->insertLabel(json_encode($var));

            exit;
        }
    } catch (Throwable $e) {
        die("nodata");
    }
}

if (isset($results)) {
    $var0 = [];
    $var1 = [];
    $var2 = [];
    $var3 = [];
    $var4 = [];
    $var5 = [];
    $var6 = [];
    $var7 = [];
    $var8 = [];
    $var9 = [];
    $time = [];
    foreach ($results as $result) {
        $var0[] = number_format((float)$result['c0'], 1, '.', '');
        $var1[] = number_format((float)$result['c1'], 1, '.', '');
        $var2[] = number_format((float)$result['c2'], 1, '.', '');
        $var3[] = number_format((float)$result['c3'], 1, '.', '');
        $var4[] = number_format((float)$result['c4'], 1, '.', '');
        $var5[] = number_format((float)$result['c5'], 1, '.', '');
        $var6[] = number_format((float)$result['c6'], 1, '.', '');
        $var7[] = number_format((float)$result['c7'], 1, '.', '');
        $var8[] = number_format((float)$result['c8'], 1, '.', '');
        $var9[] = number_format((float)$result['c9'], 1, '.', '');
        $time[] = $result['time'];
    }
    $data = array("var0" => $var0, "var1" => $var1, "var2" => $var2, "var3" => $var3, "var4" => $var4, "var5" => $var5, "var6" => $var6, "var7" => $var7, "var8" => $var8, "var9" => $var9, "time" => $time);
    if (isset($lastupdate) && !is_null($lastupdate)) {
        $data += ["lastupdate" => $lastupdate];
    }
    if (isset($label['label'])) {
        $data += ["label" => $label['label']];
    }
    // var_dump(json_encode($data));
    echo json_encode($data);
    // echo json_encode($_REQUEST);
}
