<?php


if (!empty($line_sent)) {

    
    // $db = new Database();
    // $conn = $db->getConn();
    
    if (!empty($line_sent_status))
        file_put_contents('line_sent_status.log', $line_sent_status . "\n", FILE_APPEND);
    // echo '<br>lineinline_noti:';
    // var_dump($line_sent);
    $datalog = $dateTime->format('Y-m-d H:i:s') . "  esp id : " . $_POST['esp_id'] . "\n";
    foreach ($line_sent as $line) {
        // echo '<br>lineinfirstforeach:';
        // var_dump($line);
        foreach ($line as $key => $value) {
            // echo '<br>lineinsecondforeach:';
            // var_dump($value);
            $datalog .= $key . ":" . $value . ", ";
        }


        if ($line[0] == 0) {
            $line_result = Linenotify::sentCustom($conn, $line[1], $line[2], $line[3], $line[4], $line[5], $line[6], $line[7], $line[8], $line[9], $line[10], $line[11], $line[12]);
            if ($line_result == "success")
                $payload["status"]["line"] = "sent";
            else {
                $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
                file_put_contents('1acmeter_line.log', $datalog, FILE_APPEND);
                $payload["status"]["line"] = "sent failed";
            }
        } elseif ($line[0] == 1) {
            $line_result = Linenotify::sentEnergy($conn, $line[1], $line[2], $line[3]);
            if ($line_result == "success")
                $payload["status"]["line"] = "sent";
            else {
                $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
                file_put_contents('1acmeter_line.log', $datalog, FILE_APPEND);
                $payload["status"]["line"] = "sent failed";
            }
        } elseif ($line[0] == 2) {
            $line_result = Linenotify::sentPm($conn, $line[1], $line[2], $line[3], $line[4], $line[5]);
            if ($line_result == "success")
                $payload["status"]["line"] = "sent";
            else {
                $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
                file_put_contents('2pmmeter_line.log', $datalog, FILE_APPEND);
                $payload["status"]["line"] = "sent failed";
            }
        } elseif ($line[0] == 3) {
            $line_result = Linenotify::sentEnergy($conn, $line[1], $line[2], $line[3]);
            if ($line_result == "success")
                $payload["status"]["line"] = "sent";
            else {
                $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
                file_put_contents('3dcmeter_line.log', $datalog, FILE_APPEND);
                $payload["status"]["line"] = "sent failed";
            }
        } elseif ($line[0] == 4) {
            $line_result =  Linenotify::sentDHT($conn, $line[1], $line[2], $line[3], $line[4]);
            if ($line_result == "success")
                $payload["status"]["line"] = "sent";
            else {
                $datalog = $data_sec->time . "\n-ESPID:" . $data_sec->esp_id .  "\n-Result:" . $line_result . "\n\n";
                file_put_contents('4dht_line.log', $datalog, FILE_APPEND);
                $payload["status"]["line"] = "sent failed";
            }
        }
    }
    file_put_contents('line_sent.log', $datalog . "\n", FILE_APPEND);
}
