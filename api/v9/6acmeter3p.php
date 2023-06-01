<?php

$needsecupdate = false;

$data_sec = new Data_6_sec($_POST['esp_id']);
$data_sec->time = $dateTime->format('Y-m-d H:i:s');

if (isset($data['v1']) || isset($data['i1']) || isset($data['p1']) || isset($data['e1']) || isset($data['f1']) || isset($data['pf1'])) {
    $needsecupdate = true;
    // if (isset($data['v1'])) 
    $data_sec->v1 = $data['v1'];
    // if (isset($data['i1'])) 
    $data_sec->i1 = $data['i1'];
    // if (isset($data['p1'])) 
    $data_sec->p1 = $data['p1'];
    // if (isset($data['e1'])) 
    $data_sec->e1 = $data['e1'];
    // if (isset($data['f1'])) 
    $data_sec->f1 = $data['f1'];
    // if (isset($data['pf1']))
     $data_sec->pf1 = $data['pf1'];

    // if (isset($data['v2'])) 
    $data_sec->v2 = $data['v2'];
    // if (isset($data['i2'])) 
    $data_sec->i2 = $data['i2'];
    // if (isset($data['p2'])) 
    $data_sec->p2 = $data['p2'];
    // if (isset($data['e2'])) 
    $data_sec->e2 = $data['e2'];
    // if (isset($data['f2'])) 
    $data_sec->f2 = $data['f2'];
    // if (isset($data['pf2']))
     $data_sec->pf2 = $data['pf2'];

    // if (isset($data['v3'])) 
    $data_sec->v3 = $data['v3'];
    // if (isset($data['i3'])) 
    $data_sec->i3 = $data['i3'];
    // if (isset($data['p3'])) 
    $data_sec->p3 = $data['p3'];
    // if (isset($data['e3'])) 
    $data_sec->e3 = $data['e3'];
    // if (isset($data['f3'])) 
    $data_sec->f3 = $data['f3'];
    // if (isset($data['pf3']))
     $data_sec->pf3 = $data['pf3'];

    // var_dump($data_sec);
    // exit;

    $data_sec->createTables();
}

// check last value
try {
    $lastData = Data_6_sec::getLast($_POST['esp_id']);
} catch (Throwable | Exception $e) {
    $lastData = null;
}
if (!is_null($lastData))
    $lastdatetime = new DateTime($lastData['time']);

// if ($needsecupdate && !is_null($lastData)) {
//     // validate enegy not continue by check last data with i1 data
//     if ((($data['e1'] < $lastData['e1']) || (abs($data['e1'] - $lastData['e1']) > 30)) && (!is_null($data['e1']) && !is_null($lastData['e1']))) { // e1 not more than 30 in minute
//         Data_6_sec::delLast($data_sec->esp_id);
//     } else if ((($data['e2'] < $lastData['e2']) || (abs($data['e2'] - $lastData['e2']) > 30)) &&  (!is_null($data['e2']) && !is_null($lastData['e2']))) { // e2 not more than 30 in minute
//         Data_6_sec::delLast($data_sec->esp_id);
//     } else if ((($data['e3'] < $lastData['e3']) || (abs($data['e3'] - $lastData['e3']) > 30)) && (!is_null($data['e3']) && !is_null($lastData['e3']))) { // e3 not more than 30 in minute
//         Data_6_sec::delLast($data_sec->esp_id);
//     }
//     //validate data if all data is 0
//     // if ($data_sec->v1 <= 50 || (isset($data['f1']) && $data['f1'] <= 30)) {
//     //     $needsecupdate = false;
//     // }
// }

if ($needsecupdate) {
    if (($re = $data_sec->insert()) === true) {
        $payload["status"]["sec"] = 'new sec data';
    } else {
        $payload["error"][] = '[1acmeter sec], ' .  $data_sec->time . ', error:' . json_encode($re);
    }
}

// check min diff
if (!is_null($lastData))
    $interval_min = strtotime($dateTime->format('Y-m-d H:i')) - strtotime($lastdatetime->format('Y-m-d H:i'));  //now-lastdata (in min)
else $interval_min = 0;

if ($interval_min && $needsecupdate) {
    $data_min = new Data_6_min($_POST['esp_id']);
    $data_min->createTables();

    $data_sec_av = Data_6_sec::getAvMin($data_sec->esp_id, $lastdatetime->format('Y-m-d H:i'));
    // var_dump($data_sec_av);
    // if (!is_null($data_sec_av[0]) && $data_sec_av[0] >= 50) {
        $data_min->time = $lastdatetime->format('Y-m-d H:i');
        $data_min->v1 = $data_sec_av[0];
        $data_min->i1 = $data_sec_av[1];
        $data_min->p1 = $data_sec_av[2];
        $data_min->e1 = $data_sec_av[3];
        $data_min->f1 = $data_sec_av[4];
        $data_min->pf1 = $data_sec_av[5];
        $data_min->v2 = $data_sec_av[6];
        $data_min->i2 = $data_sec_av[7];
        $data_min->p2 = $data_sec_av[8];
        $data_min->e2 = $data_sec_av[9];
        $data_min->f2 = $data_sec_av[10];
        $data_min->pf2 = $data_sec_av[11];
        $data_min->v3 = $data_sec_av[12];
        $data_min->i3 = $data_sec_av[13];
        $data_min->p3 = $data_sec_av[14];
        $data_min->e3 = $data_sec_av[15];
        $data_min->f3 = $data_sec_av[16];
        $data_min->pf3 = $data_sec_av[17];

        if (($re = $data_min->insert()) === true) {
            $payload["status"]["min"] = 'new min data';
        } else {
            $payload["error"][] = '[1acmeter min], ' .  $data_min->time . ', error:' . json_encode($re);
        }
    // }

    $interval_hour = strtotime($dateTime->format('Y-m-d H:00')) - strtotime($lastdatetime->format('Y-m-d H:00'));
    // var_dump($interval_hour);
    if ($interval_hour) {

        $data_hr = new Data_6_hr($_POST['esp_id']);
        $data_hr->createTables();

        $data_min_av = Data_6_min::getAvHr($data_sec->esp_id, $lastdatetime->format('Y-m-d H'));
        // var_dump($data_min_av);
        // if (!is_null($data_min_av[0]) && $data_min_av[0] >= 50) {
            $data_hr->time = $lastdatetime->format('Y-m-d H:00');
            $data_hr->v1 = $data_min_av[0];
            $data_hr->i1 = $data_min_av[1];
            $data_hr->p1 = $data_min_av[2];
            $data_hr->e1 = $data_min_av[3];
            $data_hr->f1 = $data_min_av[4];
            $data_hr->pf1 = $data_min_av[5];
            $data_hr->v2 = $data_min_av[6];
            $data_hr->i2 = $data_min_av[7];
            $data_hr->p2 = $data_min_av[8];
            $data_hr->e2 = $data_min_av[9];
            $data_hr->f2 = $data_min_av[10];
            $data_hr->pf2 = $data_min_av[11];
            $data_hr->v3 = $data_min_av[12];
            $data_hr->i3 = $data_min_av[13];
            $data_hr->p3 = $data_min_av[14];
            $data_hr->e3 = $data_min_av[15];
            $data_hr->f3 = $data_min_av[16];
            $data_hr->pf3 = $data_min_av[17];

            if (($re = $data_hr->insert()) === true) {
                $payload["status"]["hr"] = 'new hr data';
            } else {
                $payload["error"][] = '[1acmeter hr], ' .  $data_hr->time . ', error:' . json_encode($re);
            }
        // }

        // check last day value
        try {
            $lastDays = Data_6_day::getLast($data_sec->esp_id);
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

            $data_day = new Data_6_day($_POST['esp_id']);
            $data_day->createTables();

            for ($i = 1; $i < $interval_day; $i++) {
                // $dateTime->modify('+1 days');
                // echo $dateTime->format('Y-m-d H:i:s');

                $this_day = new DateTime($lastDays->format('Y-m-d') . '+' . $i . ' days');

                $data_hr_av = Data_6_hr::getAvDay($data_sec->esp_id, $this_day->format('Y-m-d'));


                // if (!is_null($data_hr_av[0]) && $data_hr_av[0] >= 50) {

                    $data_day->time = $this_day->format('Y-m-d');
                    $data_day->v1 = $data_hr_av[0];
                    $data_day->i1 = $data_hr_av[1];
                    $data_day->p1 = $data_hr_av[2];
                    $data_day->e1 = $data_hr_av[3];
                    $data_day->f1 = $data_hr_av[4];
                    $data_day->pf1 = $data_hr_av[5];
                    $data_day->v2 = $data_hr_av[6];
                    $data_day->i2 = $data_hr_av[7];
                    $data_day->p2 = $data_hr_av[8];
                    $data_day->e2 = $data_hr_av[9];
                    $data_day->f2 = $data_hr_av[10];
                    $data_day->pf2 = $data_hr_av[11];
                    $data_day->v3 = $data_hr_av[12];
                    $data_day->i3 = $data_hr_av[13];
                    $data_day->p3 = $data_hr_av[14];
                    $data_day->e3 = $data_hr_av[15];
                    $data_day->f3 = $data_hr_av[16];
                    $data_day->pf3 = $data_hr_av[17];

                    if (($re = $data_day->insert()) === true) {
                        $payload["status"]["day"] = 'new day data';
                    } else {
                        $payload["error"][] = '[1acmeter day], ' .  $data_day->time . ', error:' . json_encode($re);
                    }
                // }
            }
        } elseif ($interval_day && is_null($lastDays)) {
            $data_day = new Data_6_day($_POST['esp_id']);
            $data_day->createTables();

            $data_hr_av = Data_6_hr::getAvDay($data_sec->esp_id, $lastdatetime->format('Y-m-d'));

            // if (!is_null($data_hr_av[0]) && $data_hr_av[0] >= 50) {

                $data_day->time = $lastdatetime->format('Y-m-d');
                $data_day->v1 = $data_hr_av[0];
                $data_day->i1 = $data_hr_av[1];
                $data_day->p1 = $data_hr_av[2];
                $data_day->e1 = $data_hr_av[3];
                $data_day->f1 = $data_hr_av[4];
                $data_day->pf1 = $data_hr_av[5];
                $data_day->v2 = $data_hr_av[6];
                $data_day->i2 = $data_hr_av[7];
                $data_day->p2 = $data_hr_av[8];
                $data_day->e2 = $data_hr_av[9];
                $data_day->f2 = $data_hr_av[10];
                $data_day->pf2 = $data_hr_av[11];
                $data_day->v3 = $data_hr_av[12];
                $data_day->i3 = $data_hr_av[13];
                $data_day->p3 = $data_hr_av[14];
                $data_day->e3 = $data_hr_av[15];
                $data_day->f3 = $data_hr_av[16];
                $data_day->pf3 = $data_hr_av[17];

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
                $line_sent[] = [1, $data_day->e1, $data_sec->esp_id, $line_token['line_token']];
                $line_sent_status .= "project 1 line in condition \n";
                // $line_result = Linenotify::sentEnergy($conn, $data_day->e1, $data_sec->esp_id, $line_token['line_token']);
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
            Data_6_sec::deleteOldData($data_sec->esp_id);
            Data_6_min::deleteOldData($data_sec->esp_id);
            Data_6_hr::deleteOldData($data_sec->esp_id);
            Data_6_day::deleteOldData($data_sec->esp_id);
        }
    }
}
