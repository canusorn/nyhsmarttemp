<?php

$needsecupdate = false;

$data_sec = new Data_2_sec($_POST['esp_id']);
$data_sec->time = $dateTime->format('Y-m-d H:i:s');

if (isset($data['pm1']) || isset($data['pm2']) || isset($data['pm10'])) {
    $needsecupdate = true;
    // if (isset($data['pm1'])) 
    $data_sec->pm1 = $data['pm1'];
    // if (isset($data['pm2']))
     $data_sec->pm2 = $data['pm2'];
    // if (isset($data['pm10'])) 
    $data_sec->pm10 = $data['pm10'];

    // var_dump($data_sec);
    // exit;

    $data_sec->createTables();
}

// check last value
try {
    $lastData = Data_2_sec::getLast($_POST['esp_id']);
} catch (Throwable | Exception $e) {
    $lastData = null;
}
if (!is_null($lastData))
    $lastdatetime = new DateTime($lastData['time']);

if ($needsecupdate) {
    if (($re = $data_sec->insert()) === true) {
        $payload["status"]["sec"] = 'new sec data';
    } else {
        $payload["error"][] = '[2pmmeter sec], ' .  $data_sec->time . ', error:' . json_encode($re);
    }
}

    $interval_hour = strtotime($dateTime->format('Y-m-d H:00')) - strtotime($lastdatetime->format('Y-m-d H:00'));
    // var_dump($interval_hour);
    if ($interval_hour) {

        $data_hr = new Data_2_hr($_POST['esp_id']);
        $data_hr->createTables();

        $data_min_av = Data_2_sec::getAvMin($data_sec->esp_id, $lastdatetime->format('Y-m-d H'));
        // var_dump($data_min_av);
        // if (!is_null($data_min_av[0])) {
            $data_hr->time = $lastdatetime->format('Y-m-d H:00');
            $data_hr->pm1 = $data_min_av[0];
            $data_hr->pm2 = $data_min_av[1];
            $data_hr->pm10 = $data_min_av[2];

            if (($re = $data_hr->insert()) === true) {
                $payload["status"]["hr"] = 'new hr data';
            } else {
                $payload["error"][] = '[2pmmeter hr], ' .  $data_hr->time . ', error:' . json_encode($re);
            }
        // }

        // check last day value
        try {
            $lastDays = Data_2_day::getLast($data_sec->esp_id);
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

            $data_day = new Data_2_day($_POST['esp_id']);


            for ($i = 1; $i < $interval_day; $i++) {


                $this_day = new DateTime($lastDays->format('Y-m-d') . '+' . $i . ' days');

                $data_hr_av = Data_2_hr::getAvDay($data_sec->esp_id, $this_day->format('Y-m-d'));

                // if (!is_null($data_hr_av[0])) {

                    $data_day->time = $this_day->format('Y-m-d');
                    $data_day->pm1 = $data_hr_av[0];
                    $data_day->pm2 = $data_hr_av[1];
                    $data_day->pm10 = $data_hr_av[2];


                    if (($re = $data_day->insert()) === true) {
                        $payload["status"]["day"] = 'new day data';
                    } else {
                        $payload["error"][] = '[2pmmeter day], ' . $data_day->time . ', error:' . json_encode($re);
                    }
                // }
            }
        } elseif ($interval_day && is_null($lastDays)) {
            $data_day = new Data_2_day($_POST['esp_id']);
            $data_day->createTables();

            $data_hr_av = Data_2_hr::getAvDay($data_sec->esp_id, $lastdatetime->format('Y-m-d'));

            // if (!is_null($data_hr_av[0])) {

                $data_day->time = $lastdatetime->format('Y-m-d');
                $data_day->pm1 = $data_hr_av[0];
                $data_day->pm2 = $data_hr_av[1];
                $data_day->pm10 = $data_hr_av[2];
                if (($re = $data_day->insert()) === true) {
                    $payload["status"]["day"] = 'new day data';
                } else {
                    $payload["error"][] = '[2pmmeter day], ' .  $data_day->time . ', error:' . json_encode($re);
                }
                // $daily_energy = Data_2_sec::getDaily($data_sec->esp_id, $lastData['time']);
                $line_token = Linenotify::getAll($data_sec->esp_id, 2);
                if (isset($line_token['line_token']) && $line_token['daily_notify']  &&  $payload["status"]["sec"] == 'new sec data') {
                    $line_result = Linenotify::sentPm($conn, $data_day->pm1, $data_day->pm2, $data_day->pm10, $data_sec->esp_id, $line_token['line_token']);
                    if ($line_result == "success")
                        $payload["status"]["line"] = "sent";
                    else {
                        $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
                        file_put_contents('2pmmeter.log', $datalog, FILE_APPEND);
                        $payload["status"]["line"] = "sent failed";
                    }
                }
            // }
        }
        if (
            ($interval_day && is_null($lastDays)) ||
            ($interval_day >= 2 && !is_null($lastDays))
        ) {
            $line_token = Linenotify::getAll($data_sec->esp_id, 2);
            if (isset($line_token['line_token']) && $line_token['daily_notify'] &&  $payload["status"]["sec"] == 'new sec data' &&  $payload["status"]["day"] == 'new day data') {
                $line_sent[] = [2, $data_day->pm1, $data_day->pm2, $data_day->pm10, $data_sec->esp_id, $line_token['line_token']];
                $line_sent_status .= "project 2 line in condition \n";
                // $line_result = Linenotify::sentPm($conn, $data_day->pm1, $data_day->pm2, $data_day->pm10, $data_sec->esp_id, $line_token['line_token']);
                // if ($line_result == "success")
                //     $payload["status"]["line"] = "sent";
                // else {
                //     $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
                //     file_put_contents('2pmmeter.log', $datalog, FILE_APPEND);
                //     $payload["status"]["line"] = "sent failed";
                // }
            } else {
                if (isset($line_token['line_token'])) {
                    $line_sent_status .= "project 2 line not in condition -> " . $payload["status"]["sec"] .  "\n";
                }
            }

            // detele old data
            Data_2_sec::deleteOldData($data_sec->esp_id);
            Data_2_hr::deleteOldData($data_sec->esp_id);
            Data_2_day::deleteOldData($data_sec->esp_id);
        }
    }
