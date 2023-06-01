<?php


require($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');

function flagCal($timer)
{
    foreach ($timer as $key => $value) {
        if ($value >= fmod((new DateTime())->getTimestamp() + 7 * 3600, 86400)) {
            return $key;
        }
    }
}


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'] . "/dashboard/device.php?id") && (isset($_REQUEST['id']))) {

        // >>>> Security check
        if (empty($_SESSION['skey']) || empty($_REQUEST['skey']) || ($_SESSION['skey'] != $_REQUEST['skey'])) {
            Auth::block();
        }
    } else {
        Auth::block();
    }
} else {
    Auth::block();
}


$line_timer = new LineTimer();
$line_timer->esp_id = $_REQUEST['id'];
$old_line_timer = json_decode(($line_timer->getLast())['timer'], true);

// var_dump($old_line_timer);

if (isset($_POST['timer'])) {  //save data
    $new_line_timer = [fmod((new DateTime($_POST["timer"]))->getTimestamp() + 7 * 3600, 86400)];

    if ($old_line_timer) {
        // check duplicates
        foreach ($old_line_timer as $value) {
            if ($value == fmod((new DateTime($_POST["timer"]))->getTimestamp() + 7 * 3600, 86400)) {
                die("duplicates");
            }
        }
        $new_line_timer = array_merge($new_line_timer, $old_line_timer);
        usort($new_line_timer, function ($a, $b) {
            return $a <=> $b;
        });
    }

    $line_timer->flag = flagCal($new_line_timer);

    // var_dump($new_line_timer);
    // var_dump($old_line_timer);
    $line_timer->timer = json_encode($new_line_timer);
    // var_dump($line_timer);
    echo $line_timer->create();
} elseif (isset($_GET['deltime'])) {
    foreach ($old_line_timer as $key => $value) {
        if ($value == fmod((new DateTime($_REQUEST["timer"]))->getTimestamp() + 7 * 3600, 86400)) {
            unset($old_line_timer[$key]);
            break;
        }
    }
    usort($old_line_timer, function ($a, $b) {
        return $a <=> $b;
    });
    $line_timer->flag = flagCal($old_line_timer);
    $line_timer->timer = json_encode($old_line_timer);
    echo $line_timer->create();
} else {  // get data
    $data = [];
    if ($old_line_timer) {
        foreach ($old_line_timer as $line_timer) {

            // $line_timer = $line_timer - 6 * 3600;
            // echo $line_timer;
            $dateTime = date('h:i A', $line_timer - (7 * 3600));
            $data[] = [$dateTime, ""];
        }
    }
    $result = ["data" => $data];
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

// echo '{"data":[["D2","12:00 AM","0:20:00","",""],["D5","12:00 AM","0:20:00","",""]]}';