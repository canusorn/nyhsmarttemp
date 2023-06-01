<?php

$needsecupdate = false;

$data_sec = new Data_0_sec($_POST['esp_id']);
$data_sec->time = $dateTime->format('Y-m-d H:i:s');

if (isset($data['c0']) || isset($data['c1']) || isset($data['c2']) || isset($data['c3']) || isset($data['c4']) || isset($data['c5']) || isset($data['c6']) || isset($data['c7']) || isset($data['c8']) || isset($data['c9'])) {
    $needsecupdate = true;
    if (isset($data['c0'])) $data_sec->c0 = $data['c0'];
    if (isset($data['c1'])) $data_sec->c1 = $data['c1'];
    if (isset($data['c2'])) $data_sec->c2 = $data['c2'];
    if (isset($data['c3'])) $data_sec->c3 = $data['c3'];
    if (isset($data['c4'])) $data_sec->c4 = $data['c4'];
    if (isset($data['c5'])) $data_sec->c5 = $data['c5'];
    if (isset($data['c6'])) $data_sec->c6 = $data['c6'];
    if (isset($data['c7'])) $data_sec->c7 = $data['c7'];
    if (isset($data['c8'])) $data_sec->c8 = $data['c8'];
    if (isset($data['c9'])) $data_sec->c9 = $data['c9'];

    $data_sec->createTables();
}

// check last value
try {
    $lastData = Data_0_sec::getLast($_POST['esp_id']);
} catch (Throwable | Exception $e) {
    $lastData = null;
}

if (!is_null($lastData))
    $lastdatetime = new DateTime($lastData['time']);

if ($needsecupdate) {
    if (($re = $data_sec->insert()) === true) {
        $payload["status"]["sec"] = 'new sec data';
    } else {
        $payload["error"][] = '[0custom sec], ' .  $data_sec->time . ', error:' . json_encode($re);
    }
}

// // check min diff
if (!is_null($lastData))
    $interval_min = strtotime($dateTime->format('Y-m-d H:i')) - strtotime($lastdatetime->format('Y-m-d H:i'));  //now-lastdata (in min)
else $interval_min = 0;

if ($interval_min && $needsecupdate) {
    $data_min = new Data_0_min($_POST['esp_id']);
    $data_min->createTables();

    $data_sec_av = Data_0_sec::getAvMin($data_sec->esp_id, $lastdatetime->format('Y-m-d H:i'));
    // var_dump($data_sec_av);
    if (!is_null($data_sec_av[0])) {
        $data_min->time = $lastdatetime->format('Y-m-d H:i');

        if (isset($data_sec_av[0])) $data_min->c0 = $data_sec_av[0];
        if (isset($data_sec_av[1])) $data_min->c1 = $data_sec_av[1];
        if (isset($data_sec_av[2])) $data_min->c2 = $data_sec_av[2];
        if (isset($data_sec_av[3])) $data_min->c3 = $data_sec_av[3];
        if (isset($data_sec_av[4])) $data_min->c4 = $data_sec_av[4];
        if (isset($data_sec_av[5])) $data_min->c5 = $data_sec_av[5];
        if (isset($data_sec_av[6])) $data_min->c6 = $data_sec_av[6];
        if (isset($data_sec_av[7])) $data_min->c7 = $data_sec_av[7];
        if (isset($data_sec_av[8])) $data_min->c8 = $data_sec_av[8];
        if (isset($data_sec_av[9])) $data_min->c9 = $data_sec_av[9];

        if (($re = $data_min->insert()) === true) {
            $payload["status"]["min"] = 'new min data';
        } else {
            $payload["error"][] = '[0custom min], ' .  $data_min->time . ', error:' . json_encode($re);
        }
    }

    $interval_hour = strtotime($dateTime->format('Y-m-d H:00')) - strtotime($lastdatetime->format('Y-m-d H:00'));
    // var_dump($interval_hour);
    if ($interval_hour) {

        $data_hr = new Data_0_hr($_POST['esp_id']);
        $data_hr->createTables();

        $data_min_av = Data_0_min::getAvHr($data_sec->esp_id, $lastdatetime->format('Y-m-d H'));
        // var_dump($data_min_av);
        if (!is_null($data_min_av[0])) {
            $data_hr->time = $lastdatetime->format('Y-m-d H:00');

            if (isset($data_min_av[0])) $data_hr->c0 = $data_min_av[0];
            if (isset($data_min_av[1])) $data_hr->c1 = $data_min_av[1];
            if (isset($data_min_av[2])) $data_hr->c2 = $data_min_av[2];
            if (isset($data_min_av[3])) $data_hr->c3 = $data_min_av[3];
            if (isset($data_min_av[4])) $data_hr->c4 = $data_min_av[4];
            if (isset($data_min_av[5])) $data_hr->c5 = $data_min_av[5];
            if (isset($data_min_av[6])) $data_hr->c6 = $data_min_av[6];
            if (isset($data_min_av[7])) $data_hr->c7 = $data_min_av[7];
            if (isset($data_min_av[8])) $data_hr->c8 = $data_min_av[8];
            if (isset($data_min_av[9])) $data_hr->c9 = $data_min_av[9];

            if (($re = $data_hr->insert()) === true) {
                $payload["status"]["hr"] = 'new hr data';
            } else {
                $payload["error"][] = '[0custom hr], ' .  $data_hr->time . ', error:' . json_encode($re);
            }
        }

        // check last day value
        try {
            $lastDays = Data_0_day::getLast($data_sec->esp_id);
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

        // $interval_day = strtotime($dateTime->format('Y-m-d')) - strtotime($lastdatetime->format('Y-m-d'));
        // var_dump($interval_day);
        if ($interval_day >= 2 && !is_null($lastDays)) {

            $data_day = new Data_0_day($_POST['esp_id']);
            $data_day->createTables();


            for ($i = 1; $i < $interval_day; $i++) {

                $this_day = new DateTime($lastDays->format('Y-m-d') . '+' . $i . ' days');

                $data_hr_av = Data_0_hr::getAvDay($data_sec->esp_id, $this_day->format('Y-m-d'));

                if (!is_null($data_hr_av[0])) {

                    $data_day->time = $this_day->format('Y-m-d');
                    if (isset($data_hr_av[0])) $data_day->c0 = $data_hr_av[0];
                    if (isset($data_hr_av[1])) $data_day->c1 = $data_hr_av[1];
                    if (isset($data_hr_av[2])) $data_day->c2 = $data_hr_av[2];
                    if (isset($data_hr_av[3])) $data_day->c3 = $data_hr_av[3];
                    if (isset($data_hr_av[4])) $data_day->c4 = $data_hr_av[4];
                    if (isset($data_hr_av[5])) $data_day->c5 = $data_hr_av[5];
                    if (isset($data_hr_av[6])) $data_day->c6 = $data_hr_av[6];
                    if (isset($data_hr_av[7])) $data_day->c7 = $data_hr_av[7];
                    if (isset($data_hr_av[8])) $data_day->c8 = $data_hr_av[8];
                    if (isset($data_hr_av[9])) $data_day->c9 = $data_hr_av[9];

                    if (($re = $data_day->insert()) === true) {
                        $payload["status"]["day"] = 'new day data';
                    } else {
                        $payload["error"][] = '[0custom day], ' . $data_day->time . ', error:' . json_encode($re);
                    }
                }
            }
        } elseif ($interval_day && is_null($lastDays)) {
            $data_day = new Data_0_day($_POST['esp_id']);
            $data_day->createTables();

            $data_hr_av = Data_0_hr::getAvDay($data_sec->esp_id, $lastdatetime->format('Y-m-d'));

            if (!is_null($data_hr_av[0])) {

                $data_day->time = $lastdatetime->format('Y-m-d');
                if (isset($data_hr_av[0])) $data_day->c0 = $data_hr_av[0];
                if (isset($data_hr_av[1])) $data_day->c1 = $data_hr_av[1];
                if (isset($data_hr_av[2])) $data_day->c2 = $data_hr_av[2];
                if (isset($data_hr_av[3])) $data_day->c3 = $data_hr_av[3];
                if (isset($data_hr_av[4])) $data_day->c4 = $data_hr_av[4];
                if (isset($data_hr_av[5])) $data_day->c5 = $data_hr_av[5];
                if (isset($data_hr_av[6])) $data_day->c6 = $data_hr_av[6];
                if (isset($data_hr_av[7])) $data_day->c7 = $data_hr_av[7];
                if (isset($data_hr_av[8])) $data_day->c8 = $data_hr_av[8];
                if (isset($data_hr_av[9])) $data_day->c9 = $data_hr_av[9];

                if (($re = $data_day->insert()) === true) {
                    $payload["status"]["day"] = 'new day data';
                } else {
                    $payload["error"][] = '[0custom day], ' . $data_day->time . ', error:' . json_encode($re);
                }
            }
        }

        if (
            ($interval_day && is_null($lastDays)) ||
            ($interval_day >= 2 && !is_null($lastDays))
        ) {

            $line_token = Linenotify::getAll($data_sec->esp_id, 0);
            if (isset($line_token['line_token']) && $line_token['daily_notify'] &&  $payload["status"]["sec"] == 'new sec data' &&  $payload["status"]["day"] == 'new day data') {
                $line_sent[] = [0, $data_day->c0, $data_day->c1, $data_day->c2, $data_day->c3, $data_day->c4, $data_day->c5, $data_day->c6, $data_day->c7, $data_day->c8, $data_day->c9, $data_sec->esp_id, $line_token['line_token']];
                $line_sent_status .= "project 0 line in condition \n";
                // $line_result = Linenotify::sentEnergy($conn, $data_day->energy, $data_sec->esp_id, $line_token['line_token']);
                // if ($line_result == "success")
                //     $payload["status"]["line"] = "sent";
                // else {
                //     $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
                //     file_put_contents('1acmeter.log', $datalog, FILE_APPEND);
                //     $payload["status"]["line"] = "sent failed";
                // }
            }

            // detele old data
            Data_0_sec::deleteOldData($data_sec->esp_id);
            Data_0_min::deleteOldData($data_sec->esp_id);
            Data_0_hr::deleteOldData($data_sec->esp_id);
            Data_0_day::deleteOldData($data_sec->esp_id);
        }
    }
}