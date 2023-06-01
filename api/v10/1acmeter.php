<?php

$needsecupdate = false;

$data_sec = new Data_1_sec($_POST['esp_id']);
$data_sec->time = $dateTime->format('Y-m-d H:i:s');

if (isset($data['voltage']) || isset($data['current']) || isset($data['power']) || isset($data['energy']) || isset($data['frequency']) || isset($data['pf'])) {
    $needsecupdate = true;
    // if (isset($data['voltage'])) 
    $data_sec->voltage = $data['voltage'];
    // if (isset($data['current'])) 
    $data_sec->current = $data['current'];
    // if (isset($data['power'])) 
    $data_sec->power = $data['power'];
    // if (isset($data['energy'])) 
    $data_sec->energy = $data['energy'];
    // if (isset($data['frequency'])) 
    $data_sec->frequency = $data['frequency'];
    // if (isset($data['pf'])) 
    $data_sec->pf = $data['pf'];

    // var_dump($data_sec);
    // exit;

    $data_sec->createTables();
}

// check last value
try {
    $lastData = Data_1_sec::getLast($_POST['esp_id']);
} catch (Throwable | Exception $e) {
    $lastData = null;
}
if (!is_null($lastData))
    $lastdatetime = new DateTime($lastData['time']);

// if ($needsecupdate && !is_null($lastData)) {
//     // validate enegy not continue by check last data with current data
//     if (($data['energy'] < $lastData['energy']) || (abs($data['energy'] - $lastData['energy']) > 30)) { // energy not more than 30 in minute
//         Data_1_sec::delLast($data_sec->esp_id);
//     }
//     //validate data if all data is 0
//     if ($data_sec->voltage <= 50 || (isset($data['frequency']) && $data['frequency'] <= 30)) {
//         $needsecupdate = false;
//     }
// }

if ($needsecupdate) {
    if (($re = $data_sec->insert()) === true) {
        $payload["status"]["sec"] = 'new sec data';
    } else {
        $payload["error"][] = '[1acmeter sec], ' .  $data_sec->time . ', error:' . json_encode($re);
    }
}


$interval_hour = strtotime($dateTime->format('Y-m-d H:00')) - strtotime($lastdatetime->format('Y-m-d H:00'));
// var_dump($interval_hour);
if ($interval_hour) {

    $data_hr = new Data_1_hr($_POST['esp_id']);
    $data_hr->createTables();

    $data_min_av = Data_1_sec::getAvMin($data_sec->esp_id, $lastdatetime->format('Y-m-d H'));
    // var_dump($data_min_av);
    // if (!is_null($data_min_av[0]) && $data_min_av[0] >= 50) {
    $data_hr->time = $lastdatetime->format('Y-m-d H:00');
    $data_hr->voltage = $data_min_av[0];
    $data_hr->current = $data_min_av[1];
    $data_hr->power = $data_min_av[2];
    $data_hr->energy = $data_min_av[3];
    $data_hr->frequency = $data_min_av[4];
    $data_hr->pf = $data_min_av[5];

    if (($re = $data_hr->insert()) === true) {
        $payload["status"]["hr"] = 'new hr data';
    } else {
        $payload["error"][] = '[1acmeter hr], ' .  $data_hr->time . ', error:' . json_encode($re);
    }
    // }

    // check last day value
    try {
        $lastDays = Data_1_day::getLast($data_sec->esp_id);
    } catch (Throwable | Exception $e) {
        $lastDays = null;
    }

    if (!is_null($lastDays)) {
        $lastDays = new DateTime($lastDays['time']);
        // $interval_day = strtotime($dateTime->format('Y-m-d')) - strtotime($lastDays->format('Y-m-d'));
        $interval_day = date_diff($dateTime, $lastDays)->days;
    } else {
        $interval_day = strtotime($dateTime->format('Y-m-d')) - strtotime($lastdatetime->format('Y-m-d'));
        // if ($interval_day) $interval_day = 2;
    }
    // var_dump($interval_day);
    if ($interval_day >= 2 && !is_null($lastDays)) {

        $data_day = new Data_1_day($_POST['esp_id']);
        $data_day->createTables();

        for ($i = 1; $i < $interval_day; $i++) {
            // $dateTime->modify('+1 days');
            // echo $dateTime->format('Y-m-d H:i:s');

            $this_day = new DateTime($lastDays->format('Y-m-d') . '+' . $i . ' days');

            $data_hr_av = Data_1_hr::getAvDay($data_sec->esp_id, $this_day->format('Y-m-d'));


            // if (!is_null($data_hr_av[0]) && $data_hr_av[0] >= 50) {

            $data_day->time = $this_day->format('Y-m-d');
            $data_day->voltage = $data_hr_av[0];
            $data_day->current = $data_hr_av[1];
            $data_day->power = $data_hr_av[2];
            $data_day->energy = $data_hr_av[3];
            $data_day->frequency = $data_hr_av[4];
            $data_day->pf = $data_hr_av[5];

            if (($re = $data_day->insert()) === true) {
                $payload["status"]["day"] = 'new day data';
            } else {
                $payload["error"][] = '[1acmeter day], ' .  $data_day->time . ', error:' . json_encode($re);
            }
            // }
        }
    } elseif ($interval_day && is_null($lastDays)) {
        $data_day = new Data_1_day($_POST['esp_id']);
        $data_day->createTables();

        $data_hr_av = Data_1_hr::getAvDay($data_sec->esp_id, $lastdatetime->format('Y-m-d'));

        // if (!is_null($data_hr_av[0]) && $data_hr_av[0] >= 50) {

        $data_day->time = $lastdatetime->format('Y-m-d');
        $data_day->voltage = $data_hr_av[0];
        $data_day->current = $data_hr_av[1];
        $data_day->power = $data_hr_av[2];
        $data_day->energy = $data_hr_av[3];
        $data_day->frequency = $data_hr_av[4];
        $data_day->pf = $data_hr_av[5];

        if (($re = $data_day->insert()) === true) {
            $payload["status"]["day"] = 'new day data';
        } else {
            $payload["error"][] = '[1acmeter day], ' .  $data_day->time . ', error:' . json_encode($re);
        }
        // }
    }

    if (
        ($interval_day && is_null($lastDays)) ||
        ($interval_day >= 2 && !is_null($lastDays))
    ) {
        $line_token = Linenotify::getAll($data_sec->esp_id, 1);
        if (isset($line_token['line_token']) && $line_token['daily_notify'] &&  $payload["status"]["sec"] == 'new sec data' &&  $payload["status"]["day"] == 'new day data') {
            $line_sent[] = [1, $data_day->energy, $data_sec->esp_id, $line_token['line_token']];
            $line_sent_status .= "project 1 line in condition \n";
            // $line_result = Linenotify::sentEnergy($conn, $data_day->energy, $data_sec->esp_id, $line_token['line_token']);
            // if ($line_result == "success")
            //     $payload["status"]["line"] = "sent";
            // else {
            //     $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
            //     file_put_contents('1acmeter.log', $datalog, FILE_APPEND);
            //     $payload["status"]["line"] = "sent failed";
            // }
        } else {
            if (isset($line_token['line_token'])) {
                $line_sent_status .= "project 1 line not in condition -> " . $payload["status"]["sec"] .  "\n";
            }
        }

        // detele old data
        Data_1_sec::deleteOldData($data_sec->esp_id);
        Data_1_hr::deleteOldData($data_sec->esp_id);
        Data_1_day::deleteOldData($data_sec->esp_id);
    }
}
