<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');

// timer update

//check update timer control
$timer = new ControlTimer();
$timer->esp_id = $_POST['esp_id'];
$timer_fetch = $timer->getLast();
$ctimer = json_decode($timer_fetch['timedata'], true);

if (isset($_POST['timer_s'])) { //request timer from server
    $timer_out = "&32764=";
    if ($ctimer) {
        foreach ($ctimer as $key => $value) {
            date_default_timezone_set('Asia/Bangkok');
            $pin = (str_split($value['pin']))[1];
            $start_time = fmod((new DateTime($value['start']))->getTimestamp() + 7 * 3600, 86400);
            $interval_time = fmod((new DateTime($value['interval']))->getTimestamp() + 7 * 3600, 86400);
            if ($key != 0) $timer_out .= ",";
            $timer_out .= $pin . ":" . $start_time . ":" . $interval_time . ":" . $value['h-l'];
        }
        // echo format &32764={pin}:{start}:{interval}:{active h-l},{pin}:{start}:{interval}:{active h-l}

    } else {
        $timer_out .= "0";  // no data
    }
    echo $timer_out;
} else if ($ctimer) {
    if ($timer_fetch['needupdate'] == 1) { // need update == 1 is new update from server
        $timer_out = "&32764=";

        foreach ($ctimer as $key => $value) {
            date_default_timezone_set('Asia/Bangkok');
            $pin = (str_split($value['pin']))[1];
            $start_time = fmod((new DateTime($value['start']))->getTimestamp() + 7 * 3600, 86400);
            $interval_time = fmod((new DateTime($value['interval']))->getTimestamp() + 7 * 3600, 86400);
            if ($key != 0) $timer_out .= ",";
            $timer_out .= $pin . ":" . $start_time . ":" . $interval_time . ":" . $value['h-l'];
        }
        $timer->timedata = json_encode($ctimer);
        $timer->needupdate = 2;
        $timer->create();

        // echo format &32764={pin}:{start}:{interval}:{active h-l},{pin}:{start}:{interval}:{active h-l}
        echo $timer_out;
    } else if (isset($_POST['timer_c'])) {  // timer to client had updated
        $timer->timedata = json_encode($ctimer);
        $timer->needupdate = 0;
        $timer->create();
    } else if ($timer_fetch['needupdate'] == 2) { // need update == 2 is new update had sent to client but no ack
        $timer_out = "&32764=";

        foreach ($ctimer as $key => $value) {
            date_default_timezone_set('Asia/Bangkok');
            $pin = (str_split($value['pin']))[1];
            $start_time = fmod((new DateTime($value['start']))->getTimestamp() + 7 * 3600, 86400);
            $interval_time = fmod((new DateTime($value['interval']))->getTimestamp() + 7 * 3600, 86400);
            if ($key != 0) $timer_out .= ",";
            $timer_out .= $pin . ":" . $start_time . ":" . $interval_time . ":" . $value['h-l'];
        }
        $timer->timedata = json_encode($ctimer);
        $timer->needupdate = 2;
        $timer->create();

        // echo format &32764={pin}:{start}:{interval}:{active h-l},{pin}:{start}:{interval}:{active h-l}
        echo $timer_out;
    }
} else if ($timer_fetch['needupdate']) {
    echo "&32764=0";
    if (isset($_POST['timer_c'])) {  // timer to client had updated
        $timer->timedata = json_encode($ctimer);
        $timer->needupdate = 0;
        $timer->create();
    }
}

// get today timestamps
if (isset($_POST['daytimestamp_s'])) {
    date_default_timezone_set('Asia/Bangkok');
    $daytimestamp_s = fmod((new DateTime())->getTimestamp() + 7 * 3600, 86400);
    echo "&32763=" . $daytimestamp_s;
}
