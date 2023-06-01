<?php

$needsecupdate = false;

$data_sec = new Data_7_sec($_POST['esp_id']);
$data_sec->time = $dateTime->format('Y-m-d H:i:s');

if (isset($data['v1']) || isset($data['c1']) || isset($data['p1']) || isset($data['e1'])) {
    $needsecupdate = true;
    $data_sec->v1 = $data['v1'];
    $data_sec->c1 = $data['c1'];
    $data_sec->p1 = $data['p1'];
    $data_sec->e1 = $data['e1'];

    $data_sec->v2 = $data['v2'];
    $data_sec->c2 = $data['c2'];
    $data_sec->p2 = $data['p2'];
    $data_sec->e2 = $data['e2'];

    $data_sec->createTables();
}

// check last value
try {
    $lastData = Data_7_sec::getLast($_POST['esp_id']);
} catch (Throwable | Exception $e) {
    $lastData = null;
}
if (!is_null($lastData))
    $lastdatetime = new DateTime($lastData['time']);

// if ($needsecupdate && !is_null($lastData)) {
//     // validate enegy not continue by check last data with current data
//     if (($data['energy'] < $lastData['energy']) || (abs($data['energy'] - $lastData['energy']) > 1000)) { // energy not more than 30 in minute
//         Data_7_sec::delLast($data_sec->esp_id);
//     }
// }

if ($needsecupdate) {
    if (($re = $data_sec->insert()) === true) {
        $payload["status"]["sec"] = 'new sec data';
    } else {
        $payload["error"][] = '[7battery sec], ' .  $data_sec->time . ', error:' . json_encode($re);
    }
}

    $interval_hour = strtotime($dateTime->format('Y-m-d H:00')) - strtotime($lastdatetime->format('Y-m-d H:00'));
    // var_dump($interval_hour);
    if ($interval_hour) {

        $data_hr = new Data_7_hr($_POST['esp_id']);
        $data_hr->createTables();

        $data_min_av = Data_7_sec::getAvMin($data_sec->esp_id, $lastdatetime->format('Y-m-d H'));
        // var_dump($data_min_av);
        // if (!is_null($data_min_av[0]) && $data_min_av[0] > 0) {
            $data_hr->time = $lastdatetime->format('Y-m-d H:00');
            $data_hr->v1 = $data_min_av[0];
            $data_hr->c1 = $data_min_av[1];
            $data_hr->p1 = $data_min_av[2];
            $data_hr->e1 = $data_min_av[3];
            $data_hr->v2 = $data_min_av[4];
            $data_hr->c2 = $data_min_av[5];
            $data_hr->p2 = $data_min_av[6];
            $data_hr->e2 = $data_min_av[7];

            if (($re = $data_hr->insert()) === true) {
                $payload["status"]["hr"] = 'new hr data';
                Data_7_hr::vacuum($data_sec->esp_id);
            } else {
                $payload["error"][] = '[7battery hr], ' .  $data_hr->time . ', error:' . json_encode($re);
            }
        // }

        // check last day value
        try {
            $lastDays = Data_7_day::getLast($data_sec->esp_id);
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

            $data_day = new Data_7_day($_POST['esp_id']);
            $data_day->createTables();

            for ($i = 1; $i < $interval_day; $i++) {
                // $dateTime->modify('+1 days');
                // echo $dateTime->format('Y-m-d H:i:s');

                $this_day = new DateTime($lastDays->format('Y-m-d') . '+' . $i . ' days');

                $data_hr_av = Data_7_hr::getAvDay($data_sec->esp_id, $this_day->format('Y-m-d'));


                // if (!is_null($data_hr_av[0]) && $data_hr_av[0] > 0) {

                    $data_day->time = $this_day->format('Y-m-d');
                    $data_day->v1 = $data_hr_av[0];
                    $data_day->c1 = $data_hr_av[1];
                    $data_day->p1 = $data_hr_av[2];
                    $data_day->e1 = $data_hr_av[3];
                    $data_day->v2 = $data_hr_av[4];
                    $data_day->c2 = $data_hr_av[5];
                    $data_day->p2 = $data_hr_av[6];
                    $data_day->e2 = $data_hr_av[7];

                    if (($re = $data_day->insert()) === true) {
                        $payload["status"]["day"] = 'new day data';
                    } else {
                        $payload["error"][] = '[7battery day], ' .  $data_day->time . ', error:' . json_encode($re);
                    }
                // }
            }
        } elseif ($interval_day && is_null($lastDays)) {
            $data_day = new Data_7_day($_POST['esp_id']);
            $data_day->createTables();

            $data_hr_av = Data_7_hr::getAvDay($data_sec->esp_id, $lastdatetime->format('Y-m-d'));

            // if (!is_null($data_hr_av[0]) && $data_hr_av[0] > 0) {

                $data_day->time = $lastdatetime->format('Y-m-d');
                $data_day->v1 = $data_hr_av[0];
                $data_day->c1 = $data_hr_av[1];
                $data_day->p1 = $data_hr_av[2];
                $data_day->e1 = $data_hr_av[3];
                $data_day->v2 = $data_hr_av[4];
                $data_day->c2 = $data_hr_av[5];
                $data_day->p2 = $data_hr_av[6];
                $data_day->e2 = $data_hr_av[7];

                if (($re = $data_day->insert()) === true) {
                    $payload["status"]["day"] = 'new day data';
                } else {
                    $payload["error"][] = '[7battery day], ' .  $data_day->time . ', error:' . json_encode($re);
                }
            // }
        }

        if (
            ($interval_day && is_null($lastDays)) ||
            ($interval_day >= 2 && !is_null($lastDays))
        ) {
            $line_token = Linenotify::getAll($data_sec->esp_id, 3);
            if (isset($line_token['line_token']) && $line_token['daily_notify'] &&  $payload["status"]["sec"] == 'new sec data' &&  $payload["status"]["day"] == 'new day data') {
                $line_sent[] = [7, $data_day->e1, $data_sec->esp_id, $line_token['line_token']];
                $line_sent_status .= "project 7 line in condition \n";
            } else {
                if (isset($line_token['line_token'])) {
                    $line_sent_status .= "project 7 line not in condition -> " . $payload["status"]["sec"] .  "\n";
                }
            }

            // detele old data
            Data_7_sec::deleteOldData($data_sec->esp_id);
            Data_7_hr::deleteOldData($data_sec->esp_id);
            Data_7_day::deleteOldData($data_sec->esp_id);
        }
    }
