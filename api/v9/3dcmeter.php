<?php

$needsecupdate = false;

$data_sec = new Data_3_sec($_POST['esp_id']);
$data_sec->time = $dateTime->format('Y-m-d H:i:s');

if (isset($data['voltage']) || isset($data['current']) || isset($data['power']) || isset($data['energy'])) {
    $needsecupdate = true;
    // if (isset($data['voltage'])) 
    $data_sec->voltage = $data['voltage'];
    // if (isset($data['current'])) 
    $data_sec->current = $data['current'];
    // if (isset($data['power'])) 
    $data_sec->power = $data['power'];
    // if (isset($data['energy'])) 
    $data_sec->energy = $data['energy'];

    // var_dump($data_sec);
    // exit;

    $data_sec->createTables();
}

// check last value
try {
    $lastData = Data_3_sec::getLast($_POST['esp_id']);
} catch (Throwable | Exception $e) {
    $lastData = null;
}
if (!is_null($lastData))
    $lastdatetime = new DateTime($lastData['time']);

if ($needsecupdate && !is_null($lastData)) {
    // validate enegy not continue by check last data with current data
    if (($data['energy'] < $lastData['energy']) || (abs($data['energy'] - $lastData['energy']) > 1000)) { // energy not more than 30 in minute
        Data_3_sec::delLast($data_sec->esp_id);
    }
}

if ($needsecupdate) {
    if (($re = $data_sec->insert()) === true) {
        $payload["status"]["sec"] = 'new sec data';
    } else {
        $payload["error"][] = '[3dcmeter sec], ' .  $data_sec->time . ', error:' . json_encode($re);
    }
}

// check min diff
if (!is_null($lastData))
    $interval_min = strtotime($dateTime->format('Y-m-d H:i')) - strtotime($lastdatetime->format('Y-m-d H:i'));  //now-lastdata (in min)
else $interval_min = 0;

if ($interval_min && $needsecupdate) {
    $data_min = new Data_3_min($_POST['esp_id']);
    $data_min->createTables();

    $data_sec_av = Data_3_sec::getAvMin($data_sec->esp_id, $lastdatetime->format('Y-m-d H:i'));
    // var_dump($data_sec_av);
    // if (!is_null($data_sec_av[0]) && $data_sec_av[0] > 0) {
        $data_min->time = $lastdatetime->format('Y-m-d H:i');
        $data_min->voltage = $data_sec_av[0];
        $data_min->current = $data_sec_av[1];
        $data_min->power = $data_sec_av[2];
        $data_min->energy = $data_sec_av[3];

        if (($re = $data_min->insert()) === true) {
            $payload["status"]["min"] = 'new min data';
        } else {
            $payload["error"][] = '[3dcmeter min], ' .  $data_min->time . ', error:' . json_encode($re);
        }
    // }

    $interval_hour = strtotime($dateTime->format('Y-m-d H:00')) - strtotime($lastdatetime->format('Y-m-d H:00'));
    // var_dump($interval_hour);
    if ($interval_hour) {

        $data_hr = new Data_3_hr($_POST['esp_id']);
        $data_hr->createTables();

        $data_min_av = Data_3_min::getAvHr($data_sec->esp_id, $lastdatetime->format('Y-m-d H'));
        // var_dump($data_min_av);
        // if (!is_null($data_min_av[0]) && $data_min_av[0] > 0) {
            $data_hr->time = $lastdatetime->format('Y-m-d H:00');
            $data_hr->voltage = $data_min_av[0];
            $data_hr->current = $data_min_av[1];
            $data_hr->power = $data_min_av[2];
            $data_hr->energy = $data_min_av[3];

            if (($re = $data_hr->insert()) === true) {
                $payload["status"]["hr"] = 'new hr data';
                Data_3_hr::vacuum($data_sec->esp_id);
            } else {
                $payload["error"][] = '[3dcmeter hr], ' .  $data_hr->time . ', error:' . json_encode($re);
            }
        // }

        // check last day value
        try {
            $lastDays = Data_3_day::getLast($data_sec->esp_id);
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

            $data_day = new Data_3_day($_POST['esp_id']);
            $data_day->createTables();

            for ($i = 1; $i < $interval_day; $i++) {
                // $dateTime->modify('+1 days');
                // echo $dateTime->format('Y-m-d H:i:s');

                $this_day = new DateTime($lastDays->format('Y-m-d') . '+' . $i . ' days');

                $data_hr_av = Data_3_hr::getAvDay($data_sec->esp_id, $this_day->format('Y-m-d'));


                // if (!is_null($data_hr_av[0]) && $data_hr_av[0] > 0) {

                    $data_day->time = $this_day->format('Y-m-d');
                    $data_day->voltage = $data_hr_av[0];
                    $data_day->current = $data_hr_av[1];
                    $data_day->power = $data_hr_av[2];
                    $data_day->energy = $data_hr_av[3];

                    if (($re = $data_day->insert()) === true) {
                        $payload["status"]["day"] = 'new day data';
                    } else {
                        $payload["error"][] = '[3dcmeter day], ' .  $data_day->time . ', error:' . json_encode($re);
                    }
                // }
            }
        } elseif ($interval_day && is_null($lastDays)) {
            $data_day = new Data_3_day($_POST['esp_id']);
            $data_day->createTables();

            $data_hr_av = Data_3_hr::getAvDay($data_sec->esp_id, $lastdatetime->format('Y-m-d'));

            // if (!is_null($data_hr_av[0]) && $data_hr_av[0] > 0) {

                $data_day->time = $lastdatetime->format('Y-m-d');
                $data_day->voltage = $data_hr_av[0];
                $data_day->current = $data_hr_av[1];
                $data_day->power = $data_hr_av[2];
                $data_day->energy = $data_hr_av[3];

                if (($re = $data_day->insert()) === true) {
                    $payload["status"]["day"] = 'new day data';
                } else {
                    $payload["error"][] = '[3dcmeter day], ' .  $data_day->time . ', error:' . json_encode($re);
                }
            // }
        }

        if (
            ($interval_day && is_null($lastDays)) ||
            ($interval_day >= 2 && !is_null($lastDays))
        ) {
            $line_token = Linenotify::getAll($data_sec->esp_id, 3);
            if (isset($line_token['line_token']) && $line_token['daily_notify'] &&  $payload["status"]["sec"] == 'new sec data' &&  $payload["status"]["day"] == 'new day data') {
                $line_sent[] = [3, $data_day->energy, $data_sec->esp_id, $line_token['line_token']];
                $line_sent_status .= "project 3 line in condition \n";
            } else {
                if (isset($line_token['line_token'])) {
                    $line_sent_status .= "project 3 line not in condition -> " . $payload["status"]["sec"] .  "\n";
                }
            }

            // detele old data
            Data_3_sec::deleteOldData($data_sec->esp_id);
            Data_3_min::deleteOldData($data_sec->esp_id);
            Data_3_hr::deleteOldData($data_sec->esp_id);
            Data_3_day::deleteOldData($data_sec->esp_id);
        }
    }
}
